import { useEffect } from 'react'
import { Page } from '../components/Page'
import { BodyContentProvider, HeaderContentProvider } from '../components/Providers'
import { useCustomContext } from '../functions/hooks'
import { HeaderContentContext } from '../functions/context'
import { NavLink } from 'react-router-dom'
import { routes } from '../functions/links'
import { AttestationsPageManager } from '../elements/AttestationsPageManager'

export const Attestations = () => {
  const pageTitle = 'Attestations de gage'

  return (
    <Page pageTitle={pageTitle}>
      <div className='gck-attestations'>
        <h1>{pageTitle}</h1>
        <BodyContentProvider>
          <HeaderContentProvider>
            <HeaderSectionRenderer />
            <AttestationsPageManager />
          </HeaderContentProvider>
        </BodyContentProvider>
      </div>
    </Page>
  )
}

function HeaderSectionRenderer()
{
  const {setColumns} = useCustomContext(HeaderContentContext)
  
  const columnsModel = 
  [
    {name: 'all', label: 'Toute', path: ''}, 
    {name: 'attente_to_validate', label: 'En attente de validation', path: 'attente'},
    {name: 'rejected', label: 'Rejeté', path: 'rejected'},
    {name: 'accepted', label: 'Accepté', path: 'accepted'},
    {name: 'pawncredit', label: 'Prêt sur gage', path: 'pawncredit'},

  ]

  useEffect(() => {
    if (setColumns === null) return 

    setColumns(columnsModel)
    return () => setColumns([])
  }, [])
 
  return (
    <div className='gck-header-section'>
      {columnsModel.map((column, index) => (
        <LinkColumn 
          key={index} 
          label={column.label} 
          path={`${routes.attestations}/${column.path}`} 
        />
      ))}
    </div>
  )
}

function LinkColumn({label, className, path}: {label: string, className?: string, path: string})
{
  return (
    <NavLink 
      className={({isActive}) => 
        isActive ? 'clicked' : `${className}`
      }
      to={path}
  >
      <span className="link-label">{label}</span>
  </NavLink>
  )
}