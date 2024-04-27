import { Page } from '../components/Page'
import { BodyContentProvider, HeaderContentProvider } from '../components/Providers'
import { AttestationsPageManager } from '../elements/AttestationsPageManager'
import { HeaderSection } from '../components/HeaderSection'
import { routes } from '../functions/links'

export const Attestations = () => {
  const pageTitle = 'Attestations de gage'
  const headerColumnsModel = 
  [
    {name: 'all', label: 'Toutes', path: `${routes.attestations}/`}, 
    {name: 'attente_to_validate', label: 'En attente de validation', path: `${routes.attestations}/attente`},
    {name: 'rejected', label: 'Rejetées', path: `${routes.attestations}/rejected`},
    {name: 'pawncredit', label: 'Prêt sur gage', path: `${routes.attestations}/pawncredit`},

  ]

  return (
    <Page pageTitle={pageTitle}>
      <div className='gck-attestations'>
        <h1>{pageTitle}</h1>
        <BodyContentProvider>
          <HeaderContentProvider>
            <HeaderSection columns={headerColumnsModel} />
            <AttestationsPageManager />
          </HeaderContentProvider>
        </BodyContentProvider>
      </div>
    </Page>
  )
}
