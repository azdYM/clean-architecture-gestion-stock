import { Page } from '../components/Page'
import { SubmitFormButton } from '../components/Fields'
import { SearchClientField } from '../components/SearchClient'
import { 
  AdditionalClientInfo,
  CorporateGeneralInformation, 
  IndividualGeneralInformation, 
} from '../components/FieldsCollectionForClient'
import { FormWrapper } from '../components/FormWrapper'
import { useQuery } from '@tanstack/react-query'
import { ClientContext, ClientSearchResult, CorporateType, IndividualType } from '../functions/context'
import { INDIVIDUAL } from '../functions/const'
import { useContext, useState } from 'react'
import { ClientProvider } from '../components/Providers'

export const searchClient = async function(folio: any): Promise<ClientSearchResult>
{
  const res = await fetch(`http://localhost:8000/api/search-client/${folio}`)
  return res.json()
}

export const AddOrUpdatedCustomer = () => {
  const [folio, setFolio] = useState(14)

  const { data, isLoading } = useQuery({
    queryKey: ['clientSearch', folio],
    queryFn: () => searchClient(folio)
  })

  const handleSearchClient = function (searchFolio: number|string) {
    console.log(searchFolio, "recherche client")
    if (searchFolio !== folio) {
      setFolio(folio)
    }
  }

  const handleSubmitForm = (data: Record<string, any>) => {
    console.log(data, 'form submitted')
  }

  return (
    <Page pageTitle="Update un client">
      <h1 className='page-title'>
        {data === null ? 'Recherche un client ' : (
          data?.persisted ? 'Mettre à jour les données de ce client' : 'Ajouter ce client'
        )}
      </h1>
      <SearchClientField onSearchClient={handleSearchClient} isLoading={isLoading} />
      <FormWrapper onSubmit={handleSubmitForm}>
        <ClientProvider client={data}>
          <FormFieldsClient />
        </ClientProvider>
      </FormWrapper>
    </Page>
  )
}

const FormFieldsClient = function()
{
  const resultSearch = useContext(ClientContext)
  if (resultSearch === null) return
  return (
    <>
      {resultSearch?.clientType === INDIVIDUAL 
        ? <FieldsForIndividual client={resultSearch.client as IndividualType} update={resultSearch.persisted} /> 
        : <FieldsForCorporate client={resultSearch.client as CorporateType} update={resultSearch.persisted} />
      }
      <SubmitFormButton />
    </>
  )
}

const FieldsForIndividual = function({client, update}: {client: IndividualType, update: boolean})
{
  return (
    <div className='gck-form-client'>
      <IndividualGeneralInformation defaultData={client} />
      <LocationFields />
      <ContactFields />
    </div>
  )
}

const FieldsForCorporate = function({client, update}: {client: CorporateType, update: boolean})
{
  return (
    <div className='gck-form-client'>
      <CorporateGeneralInformation defaultData={client} />
      <LocationFields />
      <ContactFields />
    </div>
  )
}



const LocationFields = function() 
{
  const errors: [] = []
  const locationFields = {
    city: {label: 'Ville/Village', type: 'string'},
    region: {label: 'Region', type: 'string'},
    neighborhood: {label: 'Quartier', type: 'string'},
  }


  return (
    <AdditionalClientInfo 
      textButton='Ajouter une nouvelle adresse' 
      title='locations' 
      errors={errors} 
      fields={locationFields}
    />
  )
}

const ContactFields = function()
{
  const errors: [] = []
  const contactFields = {
    telephone: {label: 'Téléphone', type: 'string'},
    email: {label: 'Email', type: 'string'}
  }

  return (
    <AdditionalClientInfo 
      textButton='Ajouter un nouveau contact'
      title='contacts'
      errors={errors}
      fields={contactFields}
    />
  )
}
