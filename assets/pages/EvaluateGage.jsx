import React, { useEffect, useRef } from 'react'
import { Page } from '../components/Page'
import { SearchClientFromServer } from '/components/SearchClient'
import { ClientDataProvider } from '/components/Providers'
import { useCustomContext } from '/functions/hooks'
import { ClientContext } from '/functions/context'
import { CustomCollectionFields } from '/components/CustomFields'
import { FormWrapper } from '/components/FormWrapper'
import { getFormData } from '/functions/object'
import { SubmitFormButton } from '/components/Fields'
import { CardClient } from '/components/CardClient'

export const EvaluateGage = () => {
  const pageTitle = "Evaluation gage"
  const pageRef = useRef(null)

  return (
    <Page title={pageTitle} sidebar={true} ref={pageRef}>
      <h1 className='page-title'>Evaluation d'un gage</h1>
      <FormWrapper className='form-gage-content'>
        <ClientDataProvider>
          <SearchClient />
          <GageContentRenderer parent={pageRef}>
            <FormEvaluateGage />
          </GageContentRenderer>
        </ClientDataProvider>
      </FormWrapper>
    </Page>
  )
}

function GageContentRenderer({parent, children})
{
  const cardUserRef = useRef(null)
  const gageContentRef = useRef(null)

  useEffect(() => {
    const {current: page} = parent
    const {current: cardUser} = cardUserRef
    const {current: gageContent} = gageContentRef
    
    gageContent.style.width = `${page.offsetWidth - (cardUser.offsetWidth + 80)}px`
    cardUser.style.right = `${gageContent.getBoundingClientRect().left + 5}px`
    cardUser.style.top = `${page.getBoundingClientRect().top + 60}px`
  }, [])

  return (
    <div className='gck-gage-content' ref={gageContentRef}>
      {children}
      <CardClient width="340px" height="70vh" ref={cardUserRef} />
    </div>
  )
}

function SearchClient()
{
  const { client } = useCustomContext(ClientContext)
  return (
    <>
      { client === null &&  <SearchClientFromServer/> }
    </>
  )
}

function FormEvaluateGage({}) 
{
  const { client } = useCustomContext(ClientContext)
  const models = [{id: 0, name: '', quantity: 0, carrat: null, weight: null, price: null}]
  const customData = {
    name:     {type: 'string', label: "Nom de l'article"}, 
    quantity: {type: 'number', label: 'Quantité', min: 0}, 
    carrat:   {type: 'number', onChange: handleChangeCarrat, min: 0}, 
    weight:   {type: 'number', label: 'Poid', min: 0}, 
    price:    {type: 'number', label: 'Prix par gramme', disabled: true}, 
  }

  function handleChangeCarrat(e) {
    console.log(e.currentTarget.value, "change carrat")
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    const formData = new FormData(e.currentTarget)

    const formDataObject = getFormData(formData)

    console.log(formDataObject)
    console.log(formData)
  } 

  if (client === null) return
  return(
    <form className='evaluate-gage' onSubmit={handleSubmit} method='POST'>
      <CustomCollectionFields 
        customData={customData} 
        formFieldModels={models}
        collectionKey='articles' 
        textAddButton="Ajouteur une article"  
      />
      <SubmitFormButton />
    </form>
  ) 
}