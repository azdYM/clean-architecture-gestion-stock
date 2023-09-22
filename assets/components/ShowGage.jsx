import React from 'react'
import { Page } from './Page'
import { setDocumentTitle } from '/functions/dom'

export const ShowGage = () => {
  setDocumentTitle("Affichage gage")

  return (
    <Page>
      <div>ShowGage</div>
    </Page>
  )
}
