import React from 'react'
import { Page } from './Page'
import { setDocumentTitle } from '/functions/dom'

export const Home = () => {
  setDocumentTitle("Acceuil")
  return (
    <Page>
      <div>Home</div>
    </Page>
  )
}
