import { useEffect } from 'react'
import { routes } from '../functions/links'
import { getAcronyme, substring } from '../functions/string'
import { CardError } from '../components/CardError'
import { AttestationData, AttestationWorkflowPlaces, calculateTotalValues } from '../api/attestation'
import { formatNumber, formatRelativeDate } from '../functions/format'
import { useCustomContext } from '../functions/hooks'
import { BodyContentContext } from '../functions/context'
import { Link } from 'react-router-dom'

type AttestationRendererProps = {
  data: AttestationData[]|undefined,
  status: ('loading'|'error'|'success')
  error: unknown
}

export const AttestationsRenderer = function({data, status, error}: AttestationRendererProps) {
  return (
    <BodySectionRenderer>
      {status === 'loading' && <p>Loading...</p>}
      {error 
        ? <CardError error={error as Error} />
        : (
          data?.map((item, index) => 
            <CardAttestation key={index} attestation={item} />
          )
        )
      }
    </BodySectionRenderer>
  )
}

const BodySectionRenderer = ({children}: React.PropsWithChildren) =>
{
  return (
    <section className='gck-content-section'>
      {children}
    </section>
  )
}

const CardAttestation = function({attestation}: {attestation: AttestationData})
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
    <article className='gck-card-article'>
      <Link to={`${routes.showAttestation.replace(':id', `${attestation.id}`)}`}>
        <div className='article-header'>
          <ArticleAvatarRenderer 
            avatar={getAcronyme(attestation.client.name)} 
          />
          <ArticleHeaderContentRenderer 
            name={attestation.client.name} 
            folio={attestation.client.folio} 
          />
        </div>

        <div className='article-body'>
          <span>{`Attestation valorisé à ${formatNumber(totalValorisation)}`}</span>
          <span>
            {`Il contient ${attestation.items.length} article${attestation.items.length > 1 ? 's' : ''}`}
          </span>
          {attestation.currentPlace !== 'created' &&
            <span className={currentPlace.className}>{currentPlace.label}</span>
          }
          <p className='time'>
            {`Mise à jour ${formatRelativeDate(new Date(attestation.updatedAt)) }`}
          </p>
        </div>
        <div className='article-footer'></div>
      </Link>
    </article>
  )
}

const ArticleAvatarRenderer = function({avatar}: {avatar: string})
{
  return (
    <div className="article-avatar">
      <span>{avatar}</span>
    </div>
  )
}

const ArticleHeaderContentRenderer = function({name, folio}: {name: string, folio: number})
{
  return (
    <div className='article-header-content'>
      <span>{substring(name, 20)}</span>
      <span>{`Folio - ${folio}`}</span>
    </div>
  )
}

const getWorkflowPlaceProperties = function (currentPlace: keyof typeof AttestationWorkflowPlaces) {
  
  switch (currentPlace) {
    case 'created':
      return {label: "Crée", className: 'created'}
    case 'evaluated':
      return {label: "Evalué", className: 'success'}
    case 'pending_approval':
      return {label: "En attente d'approbation", className: 'urgent'}
    case 'approved':
      return {label: "Approuvé", className: 'sucess'}
    case 'rejected':
      return {label: "Rejeté", className: 'urgent'}
    case 'canceled':
      return {label: "Annulé", className: 'canceled'}
    default:
      throw new Error(`${currentPlace} n'est pas une valeur correcte pour le workflow de l'attestation`)
  }
}