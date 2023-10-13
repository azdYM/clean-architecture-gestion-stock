import { useEffect } from 'react'
import { BodyContentContext } from '../functions/context'
import { Link } from 'react-router-dom'
import { BodySectionRenderer } from '../components/AttestationsBodySection'
import { useCustomContext } from '../functions/hooks'
import { routes } from '../functions/links'
import { getAcronyme, substring } from '../functions/string'

export const AllAttestationsRenderer = () =>
{
  const data = 
  [
    {id: 1, folio: '1234', name: 'Abdoul-wahid Hassani Dafine', updatedAt: getDate(15),  totalValue: '1 000 000 KMF'},
    {id: 2, folio: '66165', name: 'Abdoul-Karim Ibrahim', updatedAt: getDate(60),  totalValue: '32 000 000 KMF'},
    {id: 3, folio: '50123', name: 'Radjabou Saandi Islam', updatedAt: getDate(2), totalValue: '500 000 KMF'},
    {id: 3, folio: '50123', name: 'Faida Moussa', updatedAt: getDate(9), totalValue: '1 000 000 KMF'},
    {id: 3, folio: '50123', name: 'Nasma Abdoul-fatah', updatedAt: getDate(12), totalValue: '5 000 000 KMF'},
    {id: 1, folio: '1234', name: 'Abdoul-wahid Hassani Dafine', updatedAt: getDate(18),  totalValue: '1 000 000 KMF'},
    {id: 2, folio: '66165', name: 'Abdoul-Karim Ibrahim', updatedAt: getDate(3),  totalValue: '32 000 000 KMF'},
    {id: 3, folio: '50123', name: 'Radjabou Saandi Islam', updatedAt: getDate(120), totalValue: '500 000 KMF'},
    {id: 3, folio: '50123', name: 'Faida Moussa', updatedAt: getDate(39), totalValue: '1 000 000 KMF'},
    {id: 3, folio: '50123', name: 'Nasma Abdoul-fatah', updatedAt: getDate(29), totalValue: '5 000 000 KMF'},
    {id: 3, folio: '50123', name: 'Mohamed Adam', updatedAt: getDate(390), totalValue: '5 000 000 KMF'},  
  ]

	function getDate(time: number)
	{
    const currentDate = new Date().getMinutes()
		return `${new Date(currentDate - time).getSeconds()/60} min`
	}

  return (
    <BodySectionRenderer>
      {data.map((item, index) => 
        <CardAttestation key={index} content={item} />)
      }
    </BodySectionRenderer>
  )
}

function CardAttestation({content}: {content: {[key: string]: any}})
{
  const {updateContents} = useCustomContext(BodyContentContext)
  
  useEffect(() => {
    if (!updateContents) return
    updateContents(content)
    return () => updateContents({})
  }, [])

  return (
    <article className='gck-card-article'>
      <Link to={`${routes.showAttestation.replace('/:id', '')}/${content.id}`}>
        <div className='article-header'>
          <ArticleAvatarRenderer avatar={getAcronyme(content.name)} />
          <ArticleHeaderContentRenderer name={content.name} folio={content.folio} />
        </div>

        <div className='article-body'>
          <span>{`Attestation valorisé à ${content.totalValue}`}</span>
          <span>{`Mise à jour il y a ${content.updatedAt}`}</span>
        </div>
        <div className='article-footer'></div>
      </Link>
    </article>
  )
}

function ArticleAvatarRenderer({avatar}: {avatar: string})
{
  return (
    <div className="article-avatar">
      <span>{avatar}</span>
    </div>
  )
}

function ArticleHeaderContentRenderer({name, folio}: {name: string, folio: number})
{
  return (
    <div className='article-header-content'>
      <span>{substring(name, 20)}</span>
      <span>{`Folio - ${folio}`}</span>
    </div>
  )
}