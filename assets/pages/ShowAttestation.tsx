import { Page } from '../components/Page'
import { useQuery } from '@tanstack/react-query'
import { useNavigate, useParams } from 'react-router-dom'
import { useState, forwardRef } from 'react'
import { CardError } from '../components/CardError'
import { CardClient, ClientData, Contact, Corporate, Individual, Location } from '../components/CardClient'
import { useRef } from 'react'
import { AttestationProvider, ClientProvider } from '../components/Providers'
import { AttestationData, Gage, getAttestation } from '../api/attestation'
import { ContentWrapperWithCard } from '../components/ContentWrapperWithCard'
import { formatNumber, formatRelativeDate } from '../functions/format'
import { useCustomContext } from '../functions/hooks'
import { AttestationContext, UserContext } from '../functions/context'
import { routes } from '../functions/links'
import { mapItemsToSelectedProperties } from './EvaluateGage'
import { useReactToPrint } from 'react-to-print'

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
  const attestationRef = useRef(null)

  const handlePrintAttestation = useReactToPrint({
    content: () => attestationRef.current
  })

  const handleUpdateAttestation = () => {
    navigate(routes.updateAttestation.replace(':id', String(data.id)))
  }
  
  return (
    <div ref={ref}>
      <AttestationProvider data={data}>
        <AttestationContentRenderer />
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
        <div style={{display: 'none'}}><AttestationToPrint ref={attestationRef} /></div>
      </AttestationProvider>
    </div>
  )
})

const ArticleColumnValue = function({value, label}: ArticleColumnValueProps) {
  if (label === 'unitPrice') {
    return <td>{formatNumber(Number(value))}</td>
  }

  if (label === 'updatedAt') {
    return <td>{formatRelativeDate(new Date(value))}</td>
  }
  
  return <td>{value}</td>
}

const TotalItemsAttestation = function() {
  const {items} = getAttestationData()
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

const AttestationToPrint = forwardRef<HTMLDivElement, {}>(function({}, ref) 
{
  const {client, evaluator} = getAttestationData()

  return (
    <div ref={ref}>
      <style type="text/css" media="print">
        {"\
        @page {\ size: landscape;\ }\
        "}
      </style>

      <div className='print'>
        <div className='attestation-print-header'>
          <div className='header-meck-moroni'>
            <div className="logo">

            </div>
            <div className='presentation'>
              <p>Mutuelle d'Epargne et de Crédit ya Komor-Moroni</p>
              <p>B.P 877 Moroni Route de la corniche Moroni Hankounou, Ngazidja  - Union des Comores</p>
              <p>Tel : 773 27 28 / 773 82 83</p>
              <p>Email : contact@meck-moroni.org</p>
            </div>
          </div>
          <HeaderClientInformation client={client}/>
        </div>
        <AttestationContentRenderer env='print' />
        <div className='attestation-print-footer'>
          <div className='print-footer-card'>
            <h3>Emprunteur</h3>
            <span>{client.name}</span>
            <div className='signature'>
              <h3>Signature</h3>
              <div></div>
            </div>
          </div>
          <div className='print-footer-card'>
            <h3>Evaluateur</h3>
            <span>{evaluator.fullname}</span>
            <div className='signature'>
              <h3>Signature</h3>
              <div></div>
            </div>
          </div>
          <div className='print-footer-card'>
            <h3>Superviseur</h3>
            <span>Nom et prénom</span>
            <div className='signature'>
              <h3>Signature</h3>
              <div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
})

const HeaderClientInformation = function ({client}: {client: ClientData}) {
  return (
    <div className='client-information'>
      <ShowGeneralInformation client={client} />
      <ShowContacts contacts={client.contacts} />
      <ShowLocations locations={client.locations} />
    </div>
  )
}

const ShowGeneralInformation = function({client}: {client: ClientData}) {
  const {name, folio} = client
   
  return (
    <div className='information-rows'>
      <div className='information-row'>
        <span>Nom et Prénom</span>
        <span>{name}</span>
      </div>
      <div className='information-row'>
        <span>Folio</span>
        <span>{folio}</span>
      </div>
      {isIndividualClient(client) && (
        <>
          <div className='information-row'>
            <span>Date de naissance</span>
            <span>{client.birthDay}</span>
          </div>
          <div className='information-row'>
            <span>Nin</span>
            <span>{client.nin}</span>
          </div>
          <div className='information-row'>
            <span>Lieu de Naissance</span>
            <span>
              {`
                ${client.birthLocation?.region},  
                ${client.birthLocation?.city}, 
                ${client.birthLocation?.neighborhood} 
              `}
            </span>
          </div>
        </>
      )}
      {isCorporateClient(client) && (
        <>
          <div className='information-row'>
            <span>Forme juridique</span>
            <span>{client.legalForm}</span>
          </div>
          <div className='information-row'>
            <span>Domaine d'activité</span>
            <span>{client.activityDomain}</span>
          </div>
          <div className='information-row'>
            <span>Registre de commerce</span>
            <span>{client.comericialRegistry}</span>
          </div>
        </>
      )}

    </div>
  )
}

const ShowContacts = function({contacts}: {contacts?: Contact[]}) {
  if (contacts === undefined || contacts.length === 0) {
    return (
      <div className='information-row'>
        <span>Contacts</span>
        <span>Auncun contact</span>
      </div>
    )
  }

  return (
    <div className='information-rows'>
      <div className='information-row'>
        <span>Téléphone</span>
        <span>
          {contacts.map(contact => (<span>{contact.telephone}</span>))}
        </span>
      </div>

      <div className='information-row'>
        <span>Email</span>
        <span>
          {contacts[contacts.length].email}
        </span>
      </div>
    </div>
  )
}

const ShowLocations = function({locations}: {locations?: Location[]}) {
  if (locations === undefined || locations.length === 0) {
    return (
      <div className='information-row'>
        <span>Adresse</span>
        <span>Auncune adresse enregistré</span>
      </div>
    )
  }
  const location = locations[locations?.length]
  return (
    <div className='information-rows'>
      <div className='information-row'>
        <span>Adresse</span>
        <span>
          {`
            ${location?.region},  
            ${location?.city}, 
            ${location?.neighborhood} 
          `}
        </span>
      </div>
    </div>
  )
}

const AttestationContentRenderer = function({env}: {env?: ('print'|'web')}) {
  return (
    <div className='attestation-content'>
      <TableContentItemsAttestation env={env} />
      <TotalItemsAttestation />
    </div>
  )
}

const TableContentItemsAttestation = function({env}: {env?: ('print'|'web')}) {
  const data = getAttestationData()
  const items = mapItemsToSelectedProperties(data.items)

  //si data contiens plusieurs items, quand on va imprimer l'attestation
  // j'aimerai avoir deux tableaux pour afficher les articles

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

const getAttestationData = function() {
  const data = useCustomContext(AttestationContext)
  if (data === null || data === undefined) {
    throw new Error('Attestation ne devrait pas être null')
  }

  return {...data}
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

export const isIndividualClient = function(object: any): object is Individual
{
  return (
    typeof object === 'object' 
    && object !== null 
    && 'nin' in object
    && 'birthDay' in object
  )
}

export const isCorporateClient = function(object: any): object is Corporate
{
  return (
    typeof object === 'object' 
    && object !== null 
    && 'legalForm' in object
    && 'comericialRegistry' in object
  )
}

