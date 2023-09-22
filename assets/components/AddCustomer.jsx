import React from 'react'
import { Page } from './Page'
import { setDocumentTitle } from '/functions/dom'

export const AddCustomer = () => {
  setDocumentTitle("Ajout client")
  return (
    <Page>
      <div>AddCustomer</div>
    </Page>
  )
}