import React, { FormEvent, useEffect, useRef, useState, forwardRef } from 'react'
import { Page } from '../components/Page'
import { SearchClientField } from '../components/SearchClient'
import { CustomCollectionFields } from '../components/CollectionFields'
import { FormWrapper } from '../components/FormWrapper'
import { CardClient } from '../components/CardClient'
import { useQuery } from '@tanstack/react-query'
import { searchClient } from './AddOrUpdateCustomer'
import { ClientProvider } from '../components/Providers'

export const EvaluateGage = () => {
  const pageRef = useRef<HTMLDivElement>(null)
  const cardRef = useRef<HTMLDivElement>(null)
  const contentRef = useRef<HTMLDivElement>(null)

  const [folio, setFolio] =  useState(17)
  const { data, isLoading } = useQuery({
    queryKey: ['clientSearch', folio],
    queryFn: () => searchClient(folio)
  })

  const handleSubmit = function(values: {}) {
    console.log(values, "handle submit va")
  }

  const handleSearchClient = function (searchFolio: number|string) {
    if (searchFolio !== folio) {
      setFolio(folio)
    }
  }

  return (
    <Page pageTitle='Evaluation gage' sidebarShowed={false} ref={pageRef}>
      <h1 className='page-title'>Evaluation d'un gage</h1>
      <SearchClientField onSearchClient={handleSearchClient} isLoading={isLoading} />
      <ClientProvider client={data}>
        {/* Ici je veux afficher le card a droit mais */}
        <ContentWrapperWithCard componentsRef={{pageRef, cardRef, contentRef}} positionCard='right'>
          <FormWrapper onSubmit={handleSubmit} className='form-gage-content'>
            <FormFieldsGageEvaluation ref={contentRef}/>
          </FormWrapper>
          <CardClient width="340px" height="70vh" ref={cardRef} />
        </ContentWrapperWithCard>
      </ClientProvider>
    </Page>
  )
}

type ComponentRefs = {
  pageRef: React.RefObject<HTMLElement>,
  contentRef: React.RefObject<HTMLElement>,
  cardRef: React.RefObject<HTMLElement>
}

type ContentWraperWithCardProps = {
  componentsRef: ComponentRefs
  positionCard: ('left'|'right')
} & React.PropsWithChildren

function ContentWrapperWithCard({componentsRef, positionCard, children}: ContentWraperWithCardProps)
{
  useEffect(() => {
    const page = getElementFromRef(componentsRef.pageRef)
    const cardUser = getElementFromRef(componentsRef.cardRef)
    const gageContent = getElementFromRef(componentsRef.contentRef)
    const pageWidth = page.offsetWidth
    const cardUserWidth = cardUser.offsetWidth
   

    gageContent.style.width = `${pageWidth - (cardUserWidth + 80)}px`
    const contentWidth = gageContent.offsetWidth
    const ration = pageWidth - (cardUserWidth + contentWidth)
    console.log(ration, pageWidth, (cardUserWidth + contentWidth), 'widt')
    cardUser.style['left'] = `${gageContent.getBoundingClientRect()[positionCard] + ration - 50}px`
    cardUser.style.top = `${page.getBoundingClientRect().top + 60}px`
  }, [])

  return (
    <>
      {children}
    </>
  )
}

const FormFieldsGageEvaluation =  forwardRef<HTMLDivElement>(function({}, ref) 
{  
  //const models = [{id: 0, name: '', quantity: 0, carrat: null, weight: null, price: null}]
  const customData = {
    name:     {type: 'string', label: "Nom de l'article"}, 
    quantity: {type: 'number', label: 'Quantité', min: 0}, 
    carrat:   {type: 'number', onChange: handleChangeCarrat, min: 0}, 
    weight:   {type: 'number', label: 'Poid', min: 0}, 
    price:    {type: 'number', label: 'Prix par gramme', disabled: true}, 
  }

  function handleChangeCarrat(e: FormEvent<HTMLInputElement>) {
    const input = e.currentTarget
    console.log(input.value, "change carrat")
  }

  return(
    <div ref={ref} className='gck-gage-content'>
      <CustomCollectionFields 
        customData={customData} 
        formFieldModels={[]}
        collectionKey='articles' 
        textAddButton="Ajouteur une article"  
      />
    </div>
  ) 
})

const getElementFromRef = function(refObject: React.RefObject<HTMLElement|null>): HTMLElement 
{
  if (refObject.current === null) {
    throw new Error(`${refObject} ne peut pas être utilisé car il n'est pas associé à aucun HTMLElement`)
  }

  return refObject.current
} 
