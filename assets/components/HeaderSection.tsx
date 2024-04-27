import { useEffect } from 'react'
import { NavLink } from "react-router-dom"
import { useCustomContext } from "../functions/hooks"
import { HeaderContentContext } from '../functions/context'

type HeaderSectionProps = {
	columns: HeaderColumn[]
}

type HeaderColumn = {
	name: string,
	label: string,
	path: string
}

export const HeaderSection = function({columns}: HeaderSectionProps)
{
  const {setColumns} = useCustomContext(HeaderContentContext)
  
  useEffect(() => {
    if (setColumns === null) return 

    setColumns(columns)
    return () => setColumns([])
  }, [])
 
  return (
    <div className='gck-header-section'>
      {columns.map((column, index) => (
        <LinkColumn 
          key={index} 
          label={column.label} 
          path={column.path} 
        />
      ))}
    </div>
  )
}

const LinkColumn = function({label, className, path}: {label: string, className?: string, path: string})
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