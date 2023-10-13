import { Page } from '../components/Page'

export const ShowCustomer = () => {
  const pageTitle = 'Affichage client'

  return (
    <Page pageTitle={pageTitle}>
      <h1 className="page-title">{pageTitle}</h1>
    </Page>
  )
}
