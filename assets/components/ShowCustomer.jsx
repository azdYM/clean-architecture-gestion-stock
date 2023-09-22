import React from 'react'
import { Page } from './Page'
import { setDocumentTitle } from '/functions/dom'

export const ShowCustomer = () => {
  setDocumentTitle("Affichage client")

  return (
    <Page>
      <div>ShowCustomer</div>
    </Page>
  )
}
