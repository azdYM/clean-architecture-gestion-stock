import { Page } from '../components/Page'
import { useQuery } from '@tanstack/react-query'
import { useNavigate, useParams } from 'react-router-dom'
import { useState, forwardRef } from 'react'
import { CardError } from '../components/CardError'
import { CardClient } from '../components/CardClient'
import { useRef } from 'react'
import { ClientProvider } from '../components/Providers'
import { AttestationData, Gage, getAttestation } from '../api/attestation'
import { ContentWrapperWithCard } from '../components/ContentWrapperWithCard'
import { formatNumber, formatRelativeDate } from '../functions/format'
import { useCustomContext } from '../functions/hooks'
import { UserContext } from '../functions/context'
import { routes } from '../functions/links'
import { mapItemsToSelectedProperties } from './EvaluateGage'

type ErrorResponse = {
  message: string
}

type ArticleColumnValueProps = {
  label: keyof Gage,
  value: string|number
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
      setError(err);
    },
  })
  
  return (
    <Page ref={pageRef} sidebarShowed={false} pageTitle={pageTitle}>
      <h1 className="page-title">{pageTitle}</h1>
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
  const navigate = useNavigate()
  const user = useCustomContext(UserContext)
  const items = mapItemsToSelectedProperties(data.items)

  const handleUpdateAttestation = () => {
    navigate(routes.updateAttestation.replace(':id', String(data.id)))
  }
  
  return (
    <div ref={ref}>
      <div className='attestation-content'>
        <TableContentItemsAttestation items={items} />
        <TotalItemsAttestation items={items} />
      </div>
      <div className='attestation-actions'>
        {Number(user?.id) === Number(data.evaluator.id) && (
          <>
            {data.canUpdate && 
              <button onClick={handleUpdateAttestation}>Modifier</button>
            }
            {user?.roles.includes('ROLE_GAGE_EVALUATOR') && 
              <button>Valider</button>
            }
            <button>Imprimer</button>
          </>
          )
        }
      
      </div>
    </div>
  )
})

const TableContentItemsAttestation = function({items}: {items: Gage[]}) {
  return (
    <div className='items-content-attestation'>
      <table>
        <thead>
          <tr>
            {Object.keys(items[0]).map(
              (column, index) => (
                <ArticleColumn 
                  key={index} 
                  column={column as keyof Gage} 
                />
              )
            )}
          </tr>
        </thead>
        <tbody>
          {items.map(
            (item, index) => <AttestationArticle key={index} article={item}/>
          )}
        </tbody>
      </table>
    </div>
  )
}

const ArticleColumn = function({column}: {column: keyof Gage}) {
  switch (column) {
    case 'id':
      return <td>ID</td>
    case 'name':
      return <td>Nom de l'article</td>  
    case 'quantity':
      return <td>Quantité</td>  
    case 'carrat':
      return <td>Carrat</td>
    case 'weight':
      return <td>Poid</td>
    case 'unitPrice':
      return <td>Prix unitaire</td>
    case 'updatedAt':
      return <td>Dernière modification</td>
    default:
      break;
  }
}

const AttestationArticle = function({article}: {article: Gage}) {
  return (
    <tr>
      {Object.entries(article).map(
        (entrie, index) => (
          <ArticleColumnValue
            key={index} 
            label={entrie[0] as keyof Gage}
            value={entrie[1]} 
          />
        )
      )}
    </tr>
  )
}

const ArticleColumnValue = function({value, label}: ArticleColumnValueProps) {
  if (label === 'unitPrice') {
    return <td>{formatNumber(Number(value))}</td>
  }

  if (label === 'updatedAt') {
    return <td>{formatRelativeDate(new Date(value))}</td>
  }

  
  return <td>{value}</td>
}

const TotalItemsAttestation = function({items}: {items: Gage[]}) {
  const { totalValorisation, totalGram, averageValuationPerGram } = calculateTotalValues(items)
  
  return (
    <div className='items-attestation-total'>
      <div className='total'>
        <span>Article Total</span>
        <span>{items.length}</span>
      </div>
      <div className='total'>
        <span>Valorisation Total</span>
        <span>{formatNumber(totalValorisation)}</span>
      </div>
      <div className='total'>
        <span>Gramme Total</span>
        <span>{formatNumber(totalGram)}</span>
      </div>
      <div className='total'>
        <span>Valorisation moyenne/gramme</span>
        <span>{formatNumber(averageValuationPerGram)}</span>
      </div>
    </div>
  )
}

export const calculateTotalValues = function(items: Gage[]) {
  const initialValue = {
    totalValorisation: 0,
    totalGram: 0,
    averageValuationPerGram: 0
  };

  const result = items.reduce((accumulator, currentItem) => {
    // Calcul des valeurs totales
    accumulator.totalValorisation += currentItem.unitPrice * currentItem.quantity;
    accumulator.totalGram += currentItem.weight;

    // Calcul de la valeur moyenne par gramme
    accumulator.averageValuationPerGram =
      accumulator.totalValorisation / accumulator.totalGram;

    return accumulator;
  }, initialValue);

  return result;
}

