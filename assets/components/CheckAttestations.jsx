import React from 'react'
import { Page } from './Page'
import { setDocumentTitle } from '/functions/dom'

export const CheckAttestations = () => {
  setDocumentTitle("Check attestation")

  return (
    <Page>
      <div>CheckAttestations</div>
    </Page>
  )
}
