import React from 'react'
import { Page } from '/components/Page'

export const ShowCustomer = () => {
  const pageTitle = 'Affichage client'

  return (
    <Page title={pageTitle}>
      <h1 className="page-title">{pageTitle}</h1>
    </Page>
  )
}
