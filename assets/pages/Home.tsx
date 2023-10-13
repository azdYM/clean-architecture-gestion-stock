import { Page } from '../components/Page'

export const Home = () => {
  const pageTitle = 'Acceuil'

  return (
    <Page pageTitle={pageTitle}>
      <h1 className="page-title">Accueil</h1>
    </Page>
  )
}
