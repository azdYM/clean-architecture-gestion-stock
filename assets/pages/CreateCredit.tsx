import { forwardRef, useRef, useState } from 'react'
import { Page } from '../components/Page'
import { useLocation } from 'react-router-dom'
import { AttestationData, getAttestation, getClientAttestationsCanMountCredit } from '../api/attestation'
import { useQuery } from '@tanstack/react-query'
import { CardError } from '../components/CardError'
import { ErrorResponse } from './ShowAttestation'
import { ContentWrapperWithCard } from '../components/ContentWrapperWithCard'
import { AttestationProvider, AttestationsProvider } from '../components/Providers'
import { CardAttestation } from '../components/CardAttestation'
import { PAWN_CREDIT_TYPE } from '../functions/const'
import { SearchClientField } from '../components/SearchClient'
import { searchClient } from './AddOrUpdateCustomer'
import { ClientSearchResult } from '../functions/context'
import { SubmitFormButton, TextInput } from '../components/Fields'
import { FormWrapper } from '../components/FormWrapper'

type CreateCreditWrapperProps = {
  refs: {
    page: React.RefObject<HTMLDivElement>,
    content: React.RefObject<HTMLDivElement>,
    card: React.RefObject<HTMLDivElement>,
  }
  fromMultiAttestation?: boolean,
}

type CreditRendererProps = {
  clientSearch: ClientSearchResult,
  pageRef: React.RefObject<HTMLDivElement>
}

export const CreateCredit = () => {
  const pageTitle = "Création d'une crédit"
  const pageRef = useRef<HTMLDivElement>(null)

  return (
    <Page ref={pageRef} pageTitle={pageTitle}>
			<h1 className="page-title">{pageTitle}</h1>

      {getCreditTargeted() === PAWN_CREDIT_TYPE && getAttestationId() !== null
        ? <PawnCreditCreate pageRef={pageRef} />
        : <GeneralCreditCreate pageRef={pageRef} />
      }
    </Page>
  )
}

const PawnCreditCreate = function({pageRef}: {pageRef: React.RefObject<HTMLDivElement>}) {
  const cardRef = useRef<HTMLDivElement>(null)
  const contentRef = useRef<HTMLDivElement>(null)
  const attestationId = getAttestationId();

  const [error, setError] = useState<ErrorResponse | null>(null)
  const {data, status} = useQuery<AttestationData, ErrorResponse>({
    queryKey: ['attestationId', attestationId],
    queryFn: () => getAttestation(attestationId),
    enabled: !!attestationId,
    onError: (err) => {
      setError(err)
    },
  })

  return (
    <div>
      {status === 'loading' && <p>Loading...</p>}
      {error 
        ? <CardError error={error as Error} />
        : (
          <AttestationProvider data={data} >
            <CreateCreditWrapper refs={{page: pageRef, content: contentRef, card: cardRef}} >
              <FormCreateCredit ref={contentRef} />
            </CreateCreditWrapper>
          </AttestationProvider>
        )
      }
    </div>
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

/**
 * Je m'en occuperai plus tard
 */
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

  return (
    <div>
      {status === 'loading' && <p>Loading...</p>}
      {error 
        ? <CardError error={error as Error} />
        : (
          <AttestationsProvider data={data}>
            <CreateCreditWrapper
              fromMultiAttestation={true}
              refs={{
                page: pageRef,
                content: contentRef,
                card: cardRef
              }}
            >
              <div ref={contentRef}>salut ! je suis plutôt bon non 😎</div>
            </CreateCreditWrapper>
          </AttestationsProvider>
        )
      }
    </div>
  )
}

const CreateCreditWrapper = function({children, refs, fromMultiAttestation}: React.PropsWithChildren<CreateCreditWrapperProps>) {
  return (
    <ContentWrapperWithCard 
      componentsRef={{
        pageRef: refs.page, 
        contentRef: refs.content, 
        cardRef: refs.card
      }} 
      positionCard='right'
    >
      {children}
      <CardAttestation
        multiAttestation={fromMultiAttestation ?? false}
        width="340px" height="70vh" 
        ref={refs.card} 
      />
    </ContentWrapperWithCard>
  )
}

const FormCreateCredit = forwardRef<HTMLDivElement, {}>(function({}, ref) {
  const handleSubmit = function(data: object) {
    console.log(data, 'handle submit')
  }

  return (
    <div ref={ref}>
      <FormWrapper onSubmit={handleSubmit} className='form-gage-content'>
        <TextInput placeholder="Capital" name='capital' />
        <TextInput placeholder="Période (Mois)" name='periode' />
        <SubmitFormButton text='Créer' />
      </FormWrapper>
    </div>
  )
})

const getCreditTargeted = function() {
  return getParamValue('type')
}

const getAttestationId = function() {
  return getParamValue('attestation')
}

const getParamValue = function(key: string) {
  const {search} = useLocation()
  const searchParams = new URLSearchParams(search)
  return searchParams.get(key)
}