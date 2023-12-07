import { useRef } from 'react'
import { Page } from '../components/Page'
import { useQuery } from '@tanstack/react-query'
import { NavLink, useNavigate, useParams } from 'react-router-dom'
import { useState, forwardRef } from 'react'
import { CardError } from '../components/CardError'
import { CardClient } from '../components/CardClient'
import { AttestationProvider, ClientProvider } from '../components/Providers'
import { AttestationData, getAttestation } from '../api/attestation'
import { ContentWrapperWithCard } from '../components/ContentWrapperWithCard'
import { useCustomContext } from '../functions/hooks'
import { UserContext } from '../functions/context'
import { routes } from '../functions/links'
import { useReactToPrint } from 'react-to-print'
import { AttestationToPrint } from '../components/PrintAttestation'
import { AttestationContentRenderer } from '../components/AttestationContent'

export type ErrorResponse = {
  message: string
}

type ButtonsFromAttestationProps = {
  data: AttestationData,
  attestationRef: React.RefObject<HTMLDivElement>
}

export const ShowAttestation = () => {
  const pageTitle = 'Attestation de valorisation de gage'
  const {id: idAttestation} = useParams()
  const pageRef = useRef<HTMLDivElement>(null)
  const cardRef = useRef<HTMLDivElement>(null)
  const contentRef = useRef<HTMLDivElement>(null)

  const [error, setError] = useState<ErrorResponse | null>(null)
  const {data, status} = useQuery<AttestationData, ErrorResponse>({
    queryKey: ['attestationId', idAttestation],
    queryFn: () => getAttestation(idAttestation),
    enabled: !!idAttestation,
    onError: (err) => {
      setError(err)
    },
  })
  
  return (
    <Page ref={pageRef} sidebarShowed={false} pageTitle={pageTitle}>
      <div>
        <h1 className="page-title">{pageTitle}</h1>
      </div>
      {status === 'loading' && <p>Loading...</p>}
      {error 
        ? <CardError error={error as Error} />
        : (
          <ClientProvider client={data?.client}>
            {/* Ici je veux afficher le card a droit */}
            <ContentWrapperWithCard componentsRef={{pageRef, cardRef, contentRef}} positionCard='right'>
              <Attestation ref={contentRef} data={data} />
              <CardClient width="340px" height="70vh" ref={cardRef} />
            </ContentWrapperWithCard>
          </ClientProvider>
        )
      }
    </Page>
  )
}

const Attestation = forwardRef<HTMLDivElement, {data?: AttestationData}>(function({data}, ref) {
  if (data === undefined) return
  const user = useCustomContext(UserContext)
  const attestationRef = useRef(null)
  const canMountCredit = /** data?.canMountCredit && **/ user?.roles.includes('ROLE_CREDIT_AGENT')

  return (
    <div ref={ref}>
      <AttestationProvider data={data}>
        {canMountCredit && 
          <NavLink to={`${routes.createCredit}?type=pawn_credit&attestation=${data.id}`}>
            <span>Monter un crédit pour cette attestation</span>
          </NavLink>
        }
        <AttestationContentRenderer />
        <ButtonsFromAttestation attestationRef={attestationRef} data={data} />
        <div style={{display: 'none'}}>
          <AttestationToPrint ref={attestationRef} />
        </div>
      </AttestationProvider>
    </div>
  )
})

const ButtonsFromAttestation = function({data, attestationRef}: ButtonsFromAttestationProps) {
  const navigate = useNavigate()
  const user = useCustomContext(UserContext)

  const handlePrintAttestation = useReactToPrint({
    content: () => attestationRef.current
  })

  const handleUpdateAttestation = () => {
    navigate(routes.updateAttestation.replace(':id', String(data.id)))
  }
  
  return (
    <>
      {Number(user?.id) === Number(data.evaluator.id) && (
        <div className='attestation-actions'>
          <>
            {data.canUpdate && 
              <button onClick={handleUpdateAttestation}>Modifier</button>
            }
            {user?.roles.includes('ROLE_GAGE_EVALUATOR') && 
              <button>Valider</button>
            }
            <button onClick={handlePrintAttestation}>Imprimer</button>
          </>
        </div>
      )}
    </>
  )
}







