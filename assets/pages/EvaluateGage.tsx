import React, { FormEvent, useRef, useState, forwardRef } from 'react'
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
import { ContentWrapperWithCard } from '../components/ContentWrapperWithCard'
import { ClientSearchResult } from '../functions/context'
import { AttestationData, Gage } from '../api/attestation'
import { useNavigate } from 'react-router-dom'

type FormGageEvaluationProps = {
  data: ClientSearchResult | AttestationData | undefined,
  error: unknown,
  pageRef: React.RefObject<HTMLElement>,
}

type FormFieldsGageEvaluationProps = {
  articles: Gage[]|null,
  creditTypeTargeted?: number,
  description?: string,
  status: "error" | "success" | "loading" | "idle",
}

export const EvaluateGage = () => {
  const pageRef = useRef<HTMLDivElement>(null)
  const [folio, setFolio] = useState<string|null>(null)

  const { data, status, fetchStatus, error } = useQuery({
    queryKey: ['clientSearch', folio],
    queryFn: () => searchClient(folio),
    enabled: !!folio,
  })
  
  const handleSearchClient = function (searchFolio: string) {
    if (searchFolio !== folio) {
      setFolio(searchFolio)
    }
  }

  return (
    <Page pageTitle='Evaluation gage' sidebarShowed={false} ref={pageRef}>
      <h1 className='page-title'>Evaluation d'un gage</h1>
      <SearchClientField onSearchClient={handleSearchClient} status={status} fetchStatus={fetchStatus} />
      <FormGageEvaluation 
        error={error}
        data={data}
        pageRef={pageRef}
      />
    </Page>
  )
}

export const FormGageEvaluation = function({data, error, pageRef}: FormGageEvaluationProps) {
  const cardRef = useRef<HTMLDivElement>(null)
  const contentRef = useRef<HTMLDivElement>(null)
  const navigate = useNavigate()

  let mutateUri = '/api/gold-evaluation'
  let articles = null
  let description = null
  let creditTypeTargeted = null
  let method: ('PUT'|'POST'|'PATCH') = 'POST'

  if (isAttestationData(data)) {
    articles = mapItemsToSelectedProperties(data.items)
    mutateUri = `/api/gold-evaluation/attestation/${data.id}`
    method = 'PUT'
    description = data.evaluatorDescription
    creditTypeTargeted = data.idCreditTypeTargeted
  }
 
  const {mutate, status} = useMutation({
    mutationFn: (data: {}) => {
      return mutateGage(data, mutateUri, method)
    },

    onError: (error, variables, context) => {
      console.log(error, 'error')
      console.log(variables, 'variables')
      console.log(context, 'contexte')
    },

    onSuccess: (data) => {
      const attestationUrl = routes.showAttestation.replace(':id', data.id)
      navigate(attestationUrl)
    }
  })

  const handleSubmit = function(values: {}) {
    const clientIdentification = getClientIdentification(`${data?.client.folio}`)
    if (typeof clientIdentification === 'number') {
      mutate({...values, clientFolio: clientIdentification})
    }
  }

  return (
    <>
    {error 
      ? <CardError error={error as Error} />
      : (
        <ClientProvider client={data?.client}>
          <ContentWrapperWithCard componentsRef={{pageRef, cardRef, contentRef}} positionCard='right'>
            <FormWrapper onSubmit={handleSubmit} className='form-gage-content'>
              <FormFieldsGageEvaluation
                status={status}
                articles={articles} 
                description={description ?? undefined}
                creditTypeTargeted={creditTypeTargeted ?? undefined}
                ref={contentRef}
              />
            </FormWrapper>
            <CardClient width="340px" height="70vh" ref={cardRef} />
          </ContentWrapperWithCard>
        </ClientProvider>
      )
    }
    </>
  )
}

const FormFieldsGageEvaluation =  forwardRef<HTMLDivElement, FormFieldsGageEvaluationProps>(function(
  {articles, description, status, creditTypeTargeted}, ref
) {  
  return(
    <div ref={ref} className='gck-gage-content'>
      <GageArticlesFields models={articles ?? undefined} />
      <div>
        <CreditTypeTargeted defaultCreditTypeTargeted={creditTypeTargeted} />
        <Description defaultDescription={description} />
      </div>
      <SubmitFormButton status={status} text='Enregistrer' />
    </div>
  ) 
})

const GageArticlesFields = function({models}: {models?: Gage[]}) {

  const customData = {
    id:         {type: 'number', label: 'id', hidden: true},
    name:       {type: 'string', label: "Nom de l'article"}, 
    quantity:   {type: 'number', label: 'Quantité', min: 0}, 
    carrat:     {type: 'number', onChange: handleChangeCarrat, min: 0}, 
    weight:     {type: 'number', label: 'Poid', min: 0}, 
    unitPrice:  {type: 'number', label: 'Prix par gramme', disabled: true}, 
  }

  function handleChangeCarrat(e: FormEvent<HTMLInputElement>) {
    const input = e.currentTarget
    console.log(input.value, "changer le prix unitaire selon le carrat saisit")
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

const CreditTypeTargeted = function({defaultCreditTypeTargeted}: {defaultCreditTypeTargeted?: number}) {
  const creditChoices = [
    {label: 'Prêt sur gage', value: 1}
  ]

  if (defaultCreditTypeTargeted) {
    defaultCreditTypeTargeted = creditChoices.filter(
      choice => choice.value === defaultCreditTypeTargeted
    )[0].value
  }

  return (
    <SelectInput 
      options={creditChoices} 
      defaultValue={String(defaultCreditTypeTargeted)} 
      name='idCreditTypeTargeted' 
      label='Type de crédit ciblé' 
    />
  )
}

const Description = function({defaultDescription}: {defaultDescription?: string}) {
  return (
    <div className='mt-3 w-full'>
      <label>Description</label><br />
      <textarea 
        defaultValue={defaultDescription}
        placeholder='description' 
        name="description"
      ></textarea>
    </div>
  )
}

const isAttestationData = function(object: any): object is AttestationData 
{
  return (
    typeof object === 'object' 
    && object !== null 
    && 'items' in object
    && 'currentPlace' in object
  )
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

export const mutateGage = async function(data: {}, uri: string, method?: 'POST'|'PUT'|'PATCH') {
  try {
    const res = await fetch(
      uri,
      {
        method: method ?? 'POST',
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

export const mapItemsToSelectedProperties = function(items: Gage[]) {
  return items.map(item => ({
    id: item.id,
    name: item.name,
    quantity: item.quantity,
    carrat: item.carrat,
    weight: item.weight,
    unitPrice: item.unitPrice,
  }))
}