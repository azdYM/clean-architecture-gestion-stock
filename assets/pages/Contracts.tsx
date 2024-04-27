import { HeaderSection } from '../components/HeaderSection'
import { Page } from '../components/Page'
import { BodyContentProvider, HeaderContentProvider } from '../components/Providers'
import { ContractsPageManager } from '../elements/ContractsPageManager'
import { routes } from '../functions/links'

export const Contracts = () => {
	const pageTitle = "Contrats de crédit"
	const headerColumnsModel = 
  [
    {name: 'all', label: 'Toute', path: `${routes.credits}/`}, 
  ]

  return (
    <Page pageTitle={pageTitle}>
      <div className='gck-attestations'>
        <h1>{pageTitle}</h1>
        <BodyContentProvider>
          <HeaderContentProvider>
            <HeaderSection columns={headerColumnsModel} />
            <ContractsPageManager />
          </HeaderContentProvider>
        </BodyContentProvider>
      </div>
    </Page>
  )
}
