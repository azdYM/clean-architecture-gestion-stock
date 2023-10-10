import React, { useEffect } from 'react'
import { BodyContentContext, HeaderContentContext } from '/functions/context'
import { getAcronyme, isEmpty, substring } from '/functions/string'
import { Link } from 'react-router-dom'
import { BodySectionRenderer } from '/components/AttestationsBodySection'
import { useCustomContext } from '/functions/hooks'
import { routes } from '/functions/links'

export const AllAttestationsRenderer = () =>
{
  const items = 
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

	function getDate(time)
	{
		return new Date(new Date() - time).getSeconds()
	}

  return (
    <BodySectionRenderer>
      {items.map((item, index) => <CardAttestation key={index} content={item} />)}
    </BodySectionRenderer>
  )
}

function CardAttestation({content})
{
  const {columns} = useCustomContext(HeaderContentContext)
  const {updateContents} = useCustomContext(BodyContentContext)
  
  useEffect(() => {
    updateContents(content)
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

function ArticleAvatarRenderer({avatar})
{
  return (
    <div className="article-avatar">
      <span>{avatar}</span>
    </div>
  )
}

function ArticleHeaderContentRenderer({name, folio})
{
  return (
    <div className='article-header-content'>
      <span>{substring(name, 20)}</span>
      <span>{`Folio - ${folio}`}</span>
    </div>
  )
}