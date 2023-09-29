import React, { useState } from 'react'
import { Page } from '../components/Page'
import { ClientContext } from '/functions/context'
import { useCustomContext } from '/functions/hooks'
import { ClientDataProvider } from '../components/Providers'
import { SubmitFormButton } from '../components/Fields'
import { SearchClientFromADBanking } from '/components/SearchClient'
import { getFormData } from '/functions/object'
import { Navigate } from 'react-router-dom'
import { routes } from '/functions/links'
import { 
  CorporateGeneralInformation, 
  IndividualGeneralInformation, 
  MoreInformationAboutAnotherProperties 
} from '/components/FieldsCollectionForClient'
import { FormWrapper } from '/components/FormWrapper'

export const AddCustomer = () => {
  const pageTitle = "Ajout d'un nouveau client"

  return (
    <Page title={pageTitle}>
      <h1 className='page-title'>Ajouter un nouveau client</h1>
      <FormWrapper>
        <ClientDataProvider>
          <SearchClientFromADBanking />
          <FormAddClient />
        </ClientDataProvider>
      </FormWrapper>
    </Page>
  )
}

function FormAddClient({method = 'POST'})
{
  const { client } = useCustomContext(ClientContext)
  const clientTypes = { CUSTOMER: 'Customer', CORPORATE: 'corporate' }
  const errors = []
  const [submited, setSubmited] = useState(false)
  
  const handleSubmit = (e) => {
    e.preventDefault()
    const formData = new FormData(e.currentTarget)
    const formDataObject = getFormData(formData)

    setSubmited(true)
    console.log(formDataObject)
  }
  
  if (client?.type === undefined) return
  if (submited) return <Navigate to={routes.showCustomer} />
  return (
    <form onSubmit={handleSubmit} method={method}>
      {client.type === clientTypes.CUSTOMER 
        ? <FieldsForIndividual errors={errors} /> 
        : <FieldsForCorporate errors={errors} />
      }
      <SubmitFormButton />
    </form>
  )
}

function FieldsForIndividual({errors})
{
  const { client } = useCustomContext(ClientContext)

  return (
    <div className='gck-form-client'>
      <IndividualGeneralInformation defaultData={client} errors={errors} />
      <LocationFields errors={errors} />
      <ContactFields errors={errors} />
    </div>
  )
}

function FieldsForCorporate({errors})
{
  return (
    <div className='gck-input-groups'>
      <CorporateGeneralInformation />
      <LocationFields errors={errors} />
      <ContactFields errors={errors}/>
    </div>
  )
}

function LocationFields({errors}) 
{
  const fields = {
    city: {label: 'Ville/Village', type: 'string'},
    region: {label: 'Region', type: 'string'},
    neighborhood: {label: 'Quartier', type: 'string'},
  }

  return (
    <MoreInformationAboutAnotherProperties 
      textButton='Ajouter une nouvelle adresse' 
      title='locations' 
      errors={errors} 
      fields={fields}
    />
  )
}

function ContactFields({errors})
{
  const fields = {
    telephone: {label: 'Téléphone', type: 'string'},
    email: {label: 'Email', type: 'string'}
  }

  return (
    <MoreInformationAboutAnotherProperties 
      textButton='Ajouter un nouveau contact'
      title='contacts'
      errors={errors}
      fields={fields}
    />
  )
}
