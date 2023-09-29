import React from 'react'
import { Page } from '/components/Page'

export const History = () => {
  const pageTitle = 'Historique'

  return (
    <Page title={pageTitle}>
      <h1 className="page-title">{pageTitle}</h1>
    </Page>
  )
}
