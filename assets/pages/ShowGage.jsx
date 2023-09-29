import React from 'react'
import { Page } from '/components/Page'

export const ShowGage = () => {
  const pageTitle = 'Affichage gage'

  return (
    <Page title={pageTitle}>
      <h1 className="page-title">{pageTitle}</h1>
    </Page>
  )
}
