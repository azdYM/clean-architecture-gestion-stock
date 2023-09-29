import React from 'react'
import { Page } from '/components/Page'

export const ShowAttestation = () => {
  const pageTitle = 'Affichage attestation'

  return (
    <Page title={pageTitle}>
      <h1 className="page-title">{pageTitle}</h1>
    </Page>
  )
}
