import React from 'react'
import { Page } from './Page'
import { setDocumentTitle } from '/functions/dom'

export const EvaluateGage = () => {
  setDocumentTitle("Evaluation de gage")

  return (
    <Page>
      <div>EvaluateGage</div>
    </Page>
  )
}
