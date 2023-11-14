import React, { FormEvent, useEffect, useRef, useState, forwardRef } from 'react'
import { Page } from '../components/Page'
import { SearchClientField } from '../components/SearchClient'
import { CustomCollectionFields } from '../components/CollectionFields'
import { FormWrapper } from '../components/FormWrapper'
import { CardClient } from '../components/CardClient'
import { useMutation, useQuery } from '@tanstack/react-query'
import { searchClient } from './AddOrUpdateCustomer'
import { ClientProvider } from '../components/Providers'
import { CardError } from '../components/CardError'
import { SelectInput, SubmitFormButton } from '../components/Fields'
import { routes } from '../functions/links'


type ComponentRefs = {
  pageRef: React.RefObject<HTMLElement>,
  contentRef: React.RefObject<HTMLElement>,
  cardRef: React.RefObject<HTMLElement>
}

type ContentWraperWithCardProps = {
  componentsRef: ComponentRefs
  positionCard: ('left'|'right')
} & React.PropsWithChildren

type GageArticle = {
  name: string,
  quantity: number,
  carrat: number,
  weight: number,
  price: number
}

export const mutateGage = async function(data: {}) {
  try {
    const res = await fetch(
      'api/evaluate-gold',
      {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json'
        }
      }
    );
    
    if (!res.ok) {
      throw new Error(`Request failed with status ${res.status}`);
    }

    return res.json();
  } catch (error) {
    throw new Error(`An error occurred: ${error}`);
  }
}

export const EvaluateGage = () => {
  const pageRef = useRef<HTMLDivElement>(null)
  const cardRef = useRef<HTMLDivElement>(null)
  const contentRef = useRef<HTMLDivElement>(null)

  const [folio, setFolio] = useState<string|null>(null)

  const { data, status, fetchStatus, error } = useQuery({
    queryKey: ['clientSearch', folio],
    queryFn: () => searchClient(folio),
    enabled: !!folio
  }) 

  const {mutate} = useMutation({
    mutationFn: (data: {}) => {
      return mutateGage(data)
    },

    onError: (error, variables, context) => {
      console.log(error, 'error')
      console.log(variables, 'variables')
      console.log(context, 'contexte')
    },

    onSuccess: (data) => {
      const attestationUrl = routes.showAttestation.replace(':id', data.id)
      window.location.replace(`${attestationUrl}`)
    }
  })

  const handleSubmit = function(values: {}) {
    const clientIdentification = getClientIdentification(folio)

    if (typeof clientIdentification === 'number') {
      mutate({...values, clientFolio: clientIdentification})
    }
  }

  const handleSearchClient = function (searchFolio: string) {
    if (searchFolio !== folio) {
      setFolio(searchFolio)
    }
  }

  return (
    <Page pageTitle='Evaluation gage' sidebarShowed={false} ref={pageRef}>
      <h1 className='page-title'>Evaluation d'un gage</h1>
      <SearchClientField onSearchClient={handleSearchClient} status={status} fetchStatus={fetchStatus} />
      {error 
        ? <CardError error={error as Error} />
        : (
          <ClientProvider client={data}>
            {/* Ici je veux afficher le card a droit */}
            <ContentWrapperWithCard componentsRef={{pageRef, cardRef, contentRef}} positionCard='right'>
              <FormWrapper onSubmit={handleSubmit} className='form-gage-content'>
                <FormFieldsGageEvaluation ref={contentRef}/>
              </FormWrapper>
              <CardClient width="340px" height="70vh" ref={cardRef} />
            </ContentWrapperWithCard>
          </ClientProvider>
        )
      }
    </Page>
  )
}

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
 
  return(
    <div ref={ref} className='gck-gage-content'>
      <GageArticlesFields />
      <div>
        <CreditTypeTargeted />
        <Description />
      </div>
      <SubmitFormButton text='Enregistrer' />
    </div>
  ) 
})

const GageArticlesFields = function({models}: {models?: GageArticle[]}) {

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

  return (
    <CustomCollectionFields 
      customData={customData} 
      formFieldModels={models ?? []}
      collectionKey='articles' 
      textAddButton="Ajouteur une article"  
    />
  )
}

const CreditTypeTargeted = function({creditType}: {creditType?: string}) {
  const creditChoices = [
    {label: 'Prêt sur gage', value: 1}
  ]

  return (
    <SelectInput 
      options={creditChoices} 
      defaultValue={creditType ?? ''} 
      name='creditTypeTargeted' 
      label='Type de crédit ciblé' 
    />
  )
}

const Description = function({description}: {description?: string}) {
  return (
    <div className='mt-3 w-full'>
      <label>Description</label><br />
      <textarea placeholder='description' name="description">{description}</textarea>
    </div>
  )
}

const getElementFromRef = function(refObject: React.RefObject<HTMLElement|null>): HTMLElement 
{
  if (refObject.current === null) {
    throw new Error(`${refObject} ne peut pas être utilisé car il n'est pas associé à aucun HTMLElement`)
  }

  return refObject.current
} 

const getClientIdentification = function(identification: string|null): string|number 
{
  if (identification === null) {
    throw new Error("L'identification du client ne peut pas être null")
  }

  const folio = parseInt(identification)
  if (!isNaN(folio)) {
    return folio
  }

  return identification
}