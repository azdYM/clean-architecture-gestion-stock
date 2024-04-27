import { useRef, useState, useMemo } from 'react'
import { Page } from '../components/Page'
import { useLocation, useNavigate } from 'react-router-dom'
import { AttestationData, getClientAttestationsCanMountCredit } from '../api/attestation'
import { useMutation, useQuery } from '@tanstack/react-query'
import { CardError } from '../components/CardError'
import { ErrorResponse } from './ShowAttestation'
import { AttestationProvider, AttestationsProvider, ClientProvider } from '../components/Providers'
import { PAWN_CREDIT_TYPE } from '../functions/const'
import { SearchClientField } from '../components/SearchClient'
import { searchClient } from './AddOrUpdateCustomer'
import { ClientSearchResult } from '../functions/context'
import { Option, SelectInput, SubmitFormButton, TextInput } from '../components/Fields'
import { FormWrapper } from '../components/FormWrapper'
import { formatNumber } from '../functions/format'
import { FolderData, getFolder } from '../api/folder'
import { lastInArray } from '../functions/array'
import { mutateResource } from './EvaluateGage'
import { routes } from '../functions/links'
import { CreditWrapper } from '../components/Credit'


type CreditRendererProps = {
  clientSearch: ClientSearchResult,
  pageRef: React.RefObject<HTMLDivElement>
}

export const CreateCredit = () => {
  const pageTitle = "Monter un dossier de crédit"
  const pageRef = useRef<HTMLDivElement>(null)

  return (
    <Page ref={pageRef} pageTitle={pageTitle}>
			<h1 className="page-title">{pageTitle}</h1>

      {getCreditTargeted() === PAWN_CREDIT_TYPE && getFolderId() !== null
        ? <PawnCreditCreate pageRef={pageRef} />
        : <GeneralCreditCreate pageRef={pageRef} />
      }
    </Page>
  )
}

const PawnCreditCreate = function({pageRef}: {pageRef: React.RefObject<HTMLDivElement>}) {
  const cardRef = useRef<HTMLDivElement>(null)
  const contentRef = useRef<HTMLDivElement>(null)
  const folderId = getFolderId();
  const [error, setError] = useState<ErrorResponse | null>(null)

  const {data: folder, status} = useQuery<FolderData, ErrorResponse>({
    queryKey: ['folderId', folderId],
    queryFn: () => getFolder(folderId),
    enabled: !!folderId,
    onError: (err) => {
      setError(err)
    },
  })

  const lastAttestation: AttestationData|null = useMemo(
    () => lastInArray(folder?.attestations ?? []), [folder]
  )
  
  if (folder && lastAttestation) {
    lastAttestation.client = folder?.client
  }
  
  return (
    <>
      {status === 'loading' && <p>Loading...</p>}
      {error 
        ? <CardError error={error as Error} />
        : (
          <AttestationProvider data={lastAttestation} >
            <ClientProvider client={lastAttestation?.client}>
              <CreditWrapper refs={{page: pageRef, content: contentRef, card: cardRef}} >
                <FormCreateCredit folderId={folder?.id as number} />
              </CreditWrapper>
            </ClientProvider>
          </AttestationProvider>
        )
      }
    </>
  )
}

const GeneralCreditCreate = function({pageRef}: {pageRef: React.RefObject<HTMLDivElement>}) {
  const [folio, setFolio] = useState<string|null>(null)

  const {data: client, status, fetchStatus} = useQuery({
    queryKey: ['clientSearch', folio],
    queryFn: () => searchClient(folio),
    enabled: !!folio,
  })
  
  const handleSearchClient = function (searchFolio: string) {
    if (searchFolio !== folio) {
      setFolio(searchFolio)
    }
  }

  return (
    <div>
      <SearchClientField 
        onSearchClient={handleSearchClient} 
        status={status} 
        fetchStatus={fetchStatus} 
      />
      {folio !== null && client !== undefined &&
        <CreditRenderer clientSearch={client} pageRef={pageRef} />
      }
    </div>
  )
}

const CreditRenderer = function({clientSearch, pageRef}: CreditRendererProps) {
  const cardRef = useRef<HTMLDivElement>(null)
  const contentRef = useRef<HTMLDivElement>(null)
  const folio = clientSearch.client.folio
  const [error, setError] = useState<ErrorResponse | null>(null)
  
  const {data, status} = useQuery<AttestationData[], ErrorResponse>({
    queryKey: ['folio', folio],
    queryFn: () => getClientAttestationsCanMountCredit(folio),
    enabled: !!folio,
    onError: (err) => {
      setError(err)
    },
  })

  let client = null;
  if (data) {
    client = data[0].client
  }

  return (
    <div>
      {status === 'loading' && <p>Loading...</p>}
      {error 
        ? <CardError error={error as Error} />
        : (
          <AttestationsProvider data={data}>
            <ClientProvider client={client}>
              <CreditWrapper
                fromMultiAttestation={true}
                refs={{
                  page: pageRef,
                  content: contentRef,
                  card: cardRef
                }}
              >
                <div ref={contentRef}>salut ! je suis plutôt bon non 😎</div>
              </CreditWrapper>
            </ClientProvider>
          </AttestationsProvider>
        )
      }
    </div>
  )
}

const FormCreateCredit = function({folderId}: {folderId: number}) {
  const createCreditUri = '/api/pawn-credit/create'
  const navigate = useNavigate()
  const {mutate, status} = useMutation({
    mutationFn: (data: {}) => {
      return mutateResource(data, createCreditUri, 'POST')
    },

    onError: (error, variables, context) => {
      console.log(error, 'error')
      console.log(variables, 'variables')
      console.log(context, 'contexte')
    },

    onSuccess: (data) => {
      console.log('credit created with succed')
      navigate(routes.showCredit.replace(':id', data.id))
    }
  })
  const periodOptions: Option[] = [
    {label: '6 mois', value: 6},
    {label: '12 mois', value: 12}
  ]

  const handleSubmit = function(data: object) {
    mutate({...data, folderId})
  }

  const handleCapitalChange = function(e: React.FormEvent) {
		const input = e.currentTarget as HTMLInputElement
    const capital = parseInt(input.value.replace(/\s/g, ''))
    input.value = isNaN(capital) ? '' : formatNumber(capital)
  }

  return (
    <FormWrapper onSubmit={handleSubmit} className='form-gage-content'>
      <TextInput onChange={handleCapitalChange} type='text' placeholder="Capital" name='capital' />
      <SelectInput 
        options={periodOptions} 
        label='Selectionner la période' 
        defaultValue={periodOptions[0].label}
        name='duration' 
      />
      <SubmitFormButton text={status === 'loading' ? 'Chargement...' : 'Créer'} />
    </FormWrapper>
  )
}

const getCreditTargeted = function() {
  return getParamValue('type')
}

const getFolderId = function() {
  return getParamValue('folder')
}

const getParamValue = function(key: string) {
  const {search} = useLocation()
  const searchParams = new URLSearchParams(search)
  return searchParams.get(key)
}