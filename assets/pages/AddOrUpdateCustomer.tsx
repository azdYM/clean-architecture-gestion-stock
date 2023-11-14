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
import { CardError } from '../components/CardError'

export const searchClient = async function(folio: any): Promise<ClientSearchResult> {
  try {
    const res = await fetch(`http://localhost:8000/api/search-client/${folio}`);
    
    if (!res.ok) {
      throw new Error(`Request failed with status ${res.status}`);
    }

    return res.json();
  } catch (error) {
    throw new Error(`An error occurred: ${error}`);
  }
}

export const AddOrUpdatedCustomer = () => {
  const [folio, setFolio] = useState<number|string|null>(null)

  const { data, status, fetchStatus, error } = useQuery({
    queryKey: ['clientSearch', folio],
    queryFn: () => searchClient(folio),
    enabled: !!folio
  })  

  console.log(data, error, "hehhehe")

  const handleSearchClient = function (searchFolio: number|string) {
    if (searchFolio !== folio) {
      setFolio(searchFolio)
    }
  }

  const handleSubmitForm = (data: Record<string, any>) => {
    console.log(data, 'form submitted')
  }

  return (
    <Page pageTitle="Update un client">
      <h1 className='page-title'>
        {data === null ? 'Recherche un client ' : (
          data?.persisted ? 'Mettre à jour les données du client' : 'Ajouter d\'un client'
        )}
      </h1>
      <SearchClientField onSearchClient={handleSearchClient} status={status} fetchStatus={fetchStatus} />
      {error 
        ? <CardError error={error as Error} />
        : (
          <FormWrapper onSubmit={handleSubmitForm}>
            <ClientProvider client={data}>
              <FormFieldsClient />
            </ClientProvider>
          </FormWrapper>
        )
      }
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
