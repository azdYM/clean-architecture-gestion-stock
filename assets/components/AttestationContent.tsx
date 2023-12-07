import { Gage, calculateTotalValues } from "../api/attestation"
import { AttestationContext } from "../functions/context"
import { formatNumber, formatRelativeDate } from "../functions/format"
import { useCustomContext } from "../functions/hooks"
import { mapItemsToSelectedProperties } from "../pages/EvaluateGage"

type ArticleColumnValueProps = {
  label: keyof Gage,
  value: string|number
}


export const AttestationContentRenderer = function({env}: {env?: ('print'|'web')}) {
	return (
		<div className='attestation-content'>
			<TableContentItemsAttestation env={env} />
			<TotalItemsAttestation />
		</div>
	)
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

const ArticleColumnValue = function({value, label}: ArticleColumnValueProps) {
  if (label === 'unitPrice') {
    return <td>{formatNumber(Number(value))}</td>
  }

  if (label === 'updatedAt') {
    return <td>{formatRelativeDate(new Date(value))}</td>
  }
  
  return <td>{value}</td>
}


