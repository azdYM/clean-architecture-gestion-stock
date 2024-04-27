import { useRef, useState, useMemo } from 'react'
import { useParams } from 'react-router-dom'
import { Page } from '../components/Page'
import { ErrorResponse } from './ShowAttestation'
import { useMutation, useQuery } from '@tanstack/react-query'
import { CardError } from '../components/CardError'
import { AttestationProvider, ClientProvider } from '../components/Providers'
import { CreditData, getCredit } from '../api/credit'
import { CreditWrapper } from '../components/Credit'
import { AttestationData } from '../api/attestation'
import { lastInArray } from '../functions/array'
import { formatNumber, formatRelativeDate } from '../functions/format'
import { mutateResource } from './EvaluateGage'
import { isEmpty } from '../functions/string'
import { useCustomContext } from '../functions/hooks'
import { UserContext } from '../functions/context'
import { useReactToPrint } from 'react-to-print'
import { ContractsToPrint } from '../components/PrintContracts'
import { EditRenderer, PrintRenderer, ValidateRenderer } from '../components/ButtonsActions'

export const ShowCredit = () => {
  const {id: idCredit} = useParams()
  const pageTitle = `Crédit ${idCredit}`
  const pageRef = useRef<HTMLDivElement>(null)
  const cardRef = useRef<HTMLDivElement>(null)
  const contentRef = useRef<HTMLDivElement>(null)
  const contractsToPrintRef = useRef<HTMLDivElement>(null)

  const [error, setError] = useState<ErrorResponse | null>(null)
  const {data: credit, status} = useQuery<CreditData, ErrorResponse>({
    queryKey: ['idCredit', idCredit],
    queryFn: () => getCredit(idCredit),
    enabled: !!idCredit,
    onError: (err) => {
      setError(err)
    },
  })
  const lastAttestation: AttestationData|null = useMemo(
    () => lastInArray(credit?.folder.attestations ?? []), [credit]
  )
  
  if (credit && lastAttestation) {
    lastAttestation.client = credit?.folder.client
  }

  return (
    <Page ref={pageRef} pageTitle={pageTitle}>
      <h1 className="page-title">Affhichage d'un crédit</h1>

      {status === 'loading' && <p>Loading...</p>}
      {error 
        ? <CardError error={error as Error} />
        : (
          <AttestationProvider data={lastAttestation} >
            <ClientProvider client={lastAttestation?.client}>
              <CreditWrapper refs={{page: pageRef, content: contentRef, card: cardRef}} >
                <CreditRenderer data={credit} />
                <CreditButtonsAction contractRef={contractsToPrintRef} credit={credit} />
                <div style={{display: 'none'}}>
                  <ContractsToPrint contracts={credit?.contracts} ref={contractsToPrintRef} />
                </div>
              </CreditWrapper>
            </ClientProvider>
          </AttestationProvider>
        )
      }
    </Page>
  )
}

const CreditRenderer = function({data}: {data?: CreditData}) {
  if (data === undefined) return
  return (
    <div className='show-credit'>
      <h2>{`Prêt sur gage Réf(${data.id})`}</h2>
      <div className='credit-content'>
        <div className='credit-content-column'>
          <span>Capital</span>
          <span>{formatNumber(data.capital)} KMF</span>
        </div>
        <div className='credit-content-column'>
          <span>Période</span>
          <span>{data.duration} mois</span>
        </div>
        <div className='credit-content-column'>
          <span>Début</span>
          <span>{formatRelativeDate(new Date(data.startedAt))}</span>
        </div>
        <div className='credit-content-column'>
          <span>Fin</span>
          <span>{formatRelativeDate(new Date(data.endAt))}</span>
        </div>
        <div className='credit-content-column'>
          <span>Interêt</span>
          <span>{data.interest}</span>
        </div>
        <div className='credit-content-column'>
          <span>Code</span>
          <span>{data.code}</span>
        </div>
        <div className='credit-content-column'>
          <span>Dossier de crédit dans le sig</span>
          <span>{data.idADBankingFolder}</span>
        </div>
      </div>
    </div>
  )
}

const CreditButtonsAction = function({credit, contractRef}: {credit?: CreditData, contractRef: React.RefObject<HTMLDivElement>}) {
  if (credit === undefined) return
  const generateContractsUri = '/api/contracts/generate'
  const [generatedContracts, setGeneratedContracts] = useState(!isEmpty(credit.contracts))
  const user = useCustomContext(UserContext)

  const {mutate, status} = useMutation({
    mutationFn: (creditId: number) => {
      return mutateResource({creditId: creditId}, generateContractsUri, 'POST')
    },

    onError: (error, variables, context) => {
      console.log(error, 'error')
      console.log(variables, 'variables')
      console.log(context, 'contexte')
    },

    onSuccess: (data) => {
      console.log(data, 'success')
      setGeneratedContracts(true)
    }
  })

  const handleUpdateCredit = () => {
    // a implementer plus tard
  }

  const handleGenerateContract = () => {
    mutate(credit.id)
  }

  const handlePrintContract = useReactToPrint({
    content: () => contractRef.current
  })

  return (
    <>
    {Number(user?.id) === credit.creditAgent.id && 
      <div className='credit-buttons-action'>
        <EditRenderer 
          disabled={status === 'loading'} 
          onClick={handleUpdateCredit}
        />
        {!generatedContracts && 
          <ValidateRenderer 
            onClick={handleGenerateContract} 
            text={status === 'loading' ? 'Chargement...' : 'Valider le crédit'}
          />
        }
        {generatedContracts && 
          <PrintRenderer 
            onClick={handlePrintContract} 
            text='Imprimer les contrats' 
          />
          
        }
      </div>
    }
    </>
  )
}
