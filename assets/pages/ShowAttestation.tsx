import { Page } from '../components/Page'

export const ShowAttestation = () => {
  const pageTitle = 'Affichage attestation'

  return (
    <Page pageTitle={pageTitle}>
      <h1 className="page-title">{pageTitle}</h1>
    </Page>
  )
}
