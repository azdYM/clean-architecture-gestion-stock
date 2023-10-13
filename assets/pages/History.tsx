import { Page } from '../components/Page'

export const History = () => {
  const pageTitle = 'Historique'

  return (
    <Page pageTitle={pageTitle}>
      <h1 className="page-title">{pageTitle}</h1>
    </Page>
  )
}
