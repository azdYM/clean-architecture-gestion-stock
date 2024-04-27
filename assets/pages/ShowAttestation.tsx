import { useRef } from 'react'
import { Page } from '../components/Page'
import { useMutation } from '@tanstack/react-query'
import { useNavigate, useParams } from 'react-router-dom'
import { forwardRef } from 'react'
import { CardError } from '../components/CardError'
import { CardClient } from '../components/CardClient'
import { AttestationProvider, ClientProvider } from '../components/Providers'
import { AttestationData, approveAttestation, fetchAttestation } from '../api/attestation'
import { ContentWrapperWithCard } from '../components/ContentWrapperWithCard'
import { useCustomContext } from '../functions/hooks'
import { AttestationContext, ClientContext, UserContext } from '../functions/context'
import { routes } from '../functions/links'
import { useReactToPrint } from 'react-to-print'
import { AttestationToPrint } from '../components/PrintAttestation'
import { AttestationContentRenderer } from '../components/AttestationContent'
import { mutateResource } from './EvaluateGage'
import { isEmpty } from '../functions/string'
import { ActionRenderer, CreateRenderer, EditRenderer, PrintRenderer, ValidateRenderer } from '../components/ButtonsActions'
import { getWorkflowPlaceProperties } from '../components/AttestationsRenderer'

export type ErrorResponse = {
  message: string
}

type ButtonsFromAttestationProps = {
  printComponent: React.RefObject<HTMLDivElement>
}

type AttestationProps = {
  data?: AttestationData, 
  refetchData?: CallableFunction
}

export const ShowAttestation = () => {
  const pageTitle = 'Attestation de valorisation de gage'
  const {id: idAttestation} = useParams()
  const pageRef = useRef<HTMLDivElement>(null)
  const cardRef = useRef<HTMLDivElement>(null)
  const contentRef = useRef<HTMLDivElement>(null)
  const {data, status, refetch, error} = fetchAttestation(idAttestation)
  
  return (
    <Page ref={pageRef} sidebarShowed={false} pageTitle={pageTitle}>
      {status === 'loading' && <p>Loading...</p>}
      {error 
        ? <CardError error={error.statusText} />
        : (
          <ClientProvider client={data?.client}>
            {/* Ici je veux afficher le card a droit */}
            <ContentWrapperWithCard componentsRef={{pageRef, cardRef, contentRef}} positionCard='right'>
              <Attestation ref={contentRef} data={data} refetchData={refetch} />
              <CardClient width="340px" height="70vh" ref={cardRef} />
            </ContentWrapperWithCard>
          </ClientProvider>
        )
      }
    </Page>
  )
}

const Attestation = forwardRef<HTMLDivElement, AttestationProps>(function({data, refetchData}, ref) {
  if (data === undefined) return
  const attestationPrintComponentRef = useRef(null)

  return (
    <div className='show-attestation' ref={ref}>
      <div className='show-attestation-header'>
        <h1>{`Attestation de garantie ${data.id}`}</h1>
        <span>{getWorkflowPlaceProperties(data.currentPlace).label}</span>
      </div>
      <AttestationProvider data={data} refetchData={refetchData}>
        <AttestationContentRenderer />
        
        <ButtonsFromAttestation 
          printComponent={attestationPrintComponentRef} 
        />
        <div style={{display: 'none'}}>
          <AttestationToPrint ref={attestationPrintComponentRef} />
        </div>
      </AttestationProvider>
    </div>
  )
})

const ButtonsFromAttestation = function({printComponent}: ButtonsFromAttestationProps) {
  return (
    <AttestationActions>
      <EvaluatorActions printComponent={printComponent} />
      <SupervisorActions />
      <CreditAgentActions />
    </AttestationActions>
  )
}

const AttestationActions = function({children}: React.PropsWithChildren)
{
  console.log('attestation render')
  return (
    <div className='attestation-actions'>
      {children}
    </div>
  )
}

const EvaluatorActions = function({printComponent}: {printComponent: React.RefObject<HTMLDivElement>})
{
  const {data: attestation, refetch} = useCustomContext(AttestationContext)
  
  if (!isAttestation(attestation)) return
  const user = useCustomContext(UserContext)
  const canEditAttestation = attestation.canEdit
  const canValidateAttestation = attestation.currentPlace === 'evaluated' && user?.roles.includes('ROLE_GAGE_EVALUATOR') 
  const canPrintAttestation = attestation.canPrint
  const validateUri = `/api/attestation/${attestation.id}/validate`

  const navigate = useNavigate()
  const {mutate, status} = useMutation({
    mutationFn: () => {
      return mutateResource({}, validateUri, 'POST')
    },

    onError: (error, variables, context) => {
      console.log(error, 'error')
      console.log(variables, 'variables')
      console.log(context, 'contexte')
    },

    onSuccess: (data) => {
      if (refetch) refetch()
      console.log(data, 'success')
    }
  })

  const handlePrintAttestation = useReactToPrint({
    content: () => printComponent.current
  })

  const handleEditAttestation = () => {
    navigate(routes.updateAttestation.replace(':id', String(attestation.id)))
  }

  const handleValidateEvaluation = () => {
    mutate()
  }

  return (
    <>
      {Number(user?.id) === Number(attestation.evaluator.id) && (
        <>
          {canEditAttestation && 
            <EditRenderer 
              onClick={handleEditAttestation} 
              disabled={status === 'loading'}
            /> 
          }
          {canValidateAttestation && 
            <ValidateRenderer 
              onClick={handleValidateEvaluation} 
              disabled={status === 'loading'}
              text={status === 'loading' ? 'Chargement...' : 'Valider'}
            />
          }
          {canPrintAttestation && <PrintRenderer onClick={handlePrintAttestation} /> }
        </>
        )}
    </>
  )
}

const CreditAgentActions = function() 
{
  const user = useCustomContext(UserContext)
  const client = useCustomContext(ClientContext)
  const {data: attestation} = useCustomContext(AttestationContext)
  const canMountCredit = attestation?.canMountCredit && user?.roles.includes('ROLE_CREDIT_AGENT')
  const createFolderUri = '/api/folder/create'

  const navigate = useNavigate()
  const {mutate, status} = useMutation({
    mutationFn: (data: {}) => {
      return mutateResource(data, createFolderUri, 'POST')
    },

    onError: (error, variables, context) => {
      console.log(error, 'error')
      console.log(variables, 'variables')
      console.log(context, 'contexte')
    },

    onSuccess: (data) => {
      navigate(`${routes.createCredit}?type=pawn_credit&folder=${data.id}`)
    }
  })

  const handleCreateFolder = function() {
    mutate({
      clientFolio: client?.folio,
      attestations: [{id: attestation?.id}]
    })
  } 

  const handleRenewContract = function() {

  }

  return (
    <>
      {canMountCredit && 
        <>
          <CreateRenderer 
            onClick={handleCreateFolder} 
            text={status === 'loading' ? 'chargement...' : 'Créer un crédit'}
          />
          <CreateRenderer 
            onClick={handleRenewContract}
            text='Rénouveler le contrat'
            className='secondary'
          />
        </>
      }
    </>
  )
}

const SupervisorActions = function() {
  const {data: attestation, refetch} = useCustomContext(AttestationContext)
  const user = useCustomContext(UserContext)
  
  if (
    !isAttestation(attestation) || 
    attestation.currentPlace !== 'pending_approval'
  ) {
    return
  }

  const onSuccess = function() {
    refetch && refetch()
  }

  const approveUri = `/api/attestation/${attestation.id}/approve`
  const rejectUri = `/api/attestation/${attestation.id}/reject`

  const {mutate: approve, status: approveStatus} = approveAttestation(approveUri, onSuccess)
  const {mutate: reject, status: rejectStatus} = approveAttestation(rejectUri, onSuccess)

  const handleApproveAttestation = () => {
    approve()
  }

  const handleRejectAttestation = () => {
    reject()
  }

  return (
    <>
    {user?.roles.includes('ROLE_GAGE_SUPERVISOR') &&
      <>
        <ActionRenderer 
          className='btn-approve'
          onClick={handleApproveAttestation} 
          disabled={approveStatus === 'loading' || rejectStatus === 'loading'}
          text={approveStatus === 'loading' ? 'Chargement...' : 'Approuver'}
        />
        <ActionRenderer 
          className='btn-reject'
          onClick={handleRejectAttestation} 
          disabled={approveStatus === 'loading' || rejectStatus === 'loading'}
          text={rejectStatus === 'loading' ? 'Chargement...' : 'Rejeter'}
        />
      </>
    }
    </>
  )
}

const isAttestation = function(attestation: AttestationData|undefined|null): attestation is AttestationData
{
  return !isEmpty(attestation) 
}






