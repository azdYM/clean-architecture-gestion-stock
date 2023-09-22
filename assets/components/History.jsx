import React from 'react'
import { Page } from './Page'
import { setDocumentTitle } from '/functions/dom'

export const History = () => {
  setDocumentTitle("Historique")

  return (
    <Page>
      <div>History</div>
    </Page>
  )
}
