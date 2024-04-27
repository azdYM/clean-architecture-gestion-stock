import { useEffect } from 'react'
import { routes } from '../functions/links'
import { CardError } from './CardError'
import { AttestationData, AttestationGrouped, AttestationWorkflowPlaces, calculateTotalValues } from '../api/attestation'
import { formatDate, formatNumber, formatRelativeDate } from '../functions/format'
import { useCustomContext } from '../functions/hooks'
import { BodyContentContext } from '../functions/context'
import { ContainerSectionRenderer } from './SectionRenderer'
import { ItemResource } from './CardAndItemResource'

type AttestationRendererProps = {
  data: AttestationGrouped[]|undefined,
  status: ('loading'|'error'|'success')
  error: unknown
}

export const AttestationsRenderer = function({data, status, error}: AttestationRendererProps) {
  return (
    <ContainerSectionRenderer>
      {status === 'loading' && <p>Loading...</p>}
      {error 
        ? <CardError error={error as Error} />
        : (
          data?.map((item, index) => 
            <GroupAttestation key={index} attestation={item} />
          )
        )
      }
    </ContainerSectionRenderer>
  )
}

const GroupAttestation = function({attestation}: {attestation: AttestationGrouped})
{
  return (
    <div className='collection-grouped'>
      <span className='collection-grouped-title'>{formatDate(attestation.updatedAt)}</span>
      <div className='collection-grouped-content'>
        {(
          attestation.data?.map((item, index) => 
            <ItemAttestation key={index} attestation={item} />
          )
        )}
      </div>
    </div>
  )
}

const ItemAttestation = function({attestation}: {attestation: AttestationData})
{
  const { updateContents } = useCustomContext(BodyContentContext)
  const { totalValorisation } = calculateTotalValues(attestation.items)
  const currentPlace = getWorkflowPlaceProperties(attestation.currentPlace)

  useEffect(() => {
    if (!updateContents) return
    updateContents(attestation)
    return () => updateContents({})
  }, [])

  return (
    <ItemResource 
      client={attestation.client}
      clickedCardLink={`${routes.showAttestation.replace(':id', `${attestation.id}`)}`}
    >
      <span>{`Attestation valorisé à ${formatNumber(totalValorisation)} KMF`}</span>
      <span>
        {`Il contient ${attestation.items.length} article${attestation.items.length > 1 ? 's' : ''}`}
      </span>
      {attestation.currentPlace !== 'created' &&
        <span className={currentPlace.className}>{currentPlace.label}</span>
      }
      <p className='time'>
        {`Mise à jour ${formatRelativeDate(new Date(attestation.updatedAt)) }`}
      </p>
    </ItemResource>
  )
}

export const getWorkflowPlaceProperties = function (currentPlace: keyof typeof AttestationWorkflowPlaces) {
  
  switch (currentPlace) {
    case 'created':
      return {label: "Crée", className: 'created'}
    case 'evaluated':
      return {label: "Evalué", className: 'success'}
    case 'pending_approval':
      return {label: "En attente d'approbation", className: 'urgent'}
    case 'approved':
      return {label: "Approuvé", className: 'approved'}
    case 'rejected':
      return {label: "Rejeté", className: 'rejected'}
    case 'canceled':
      return {label: "Annulé", className: 'canceled'}
    default:
      throw new Error(`${currentPlace} n'est pas une valeur correcte pour le workflow de l'attestation`)
  }
}