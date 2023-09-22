import React from 'react'
import { Page } from './Page'
import { setDocumentTitle } from '/functions/dom'

export const ShowAttestation = () => {
  setDocumentTitle("Affichage attestation")

  return (
      <Page>
        <div>ShowAttestation</div>
    </Page>
  )
}
