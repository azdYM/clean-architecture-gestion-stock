import React, { useRef } from "react"
import { Icon } from "./Icon"
import { isEmpty } from "../functions/string"
import { $ } from "../functions/dom"
import { FetchStatus } from "@tanstack/react-query"

type SearchClientFieldProps = {
  status: string,
  fetchStatus: FetchStatus
  onSearchClient: (searchValue: (string)) => void
}

export const SearchClientField = ({onSearchClient, status, fetchStatus}: SearchClientFieldProps) =>
{
  const input = useRef<HTMLInputElement>(null)

  const handleFocus = (e: React.FocusEvent<HTMLInputElement>) => {
    const parent = getParentElement(e.currentTarget as HTMLElement)
    parent.classList.add('focus')
  } 

  const handleBlur = (e: React.FocusEvent<HTMLInputElement>) => {
    const parent = getParentElement(e.currentTarget as HTMLElement)
    parent.classList.remove('focus')
  } 

  const handlKeyUp = (e: React.KeyboardEvent<HTMLInputElement>) => {
    if (e.key === "Enter" || e.key === "Return") {
      handleSearchClient(e.currentTarget)
    }
  }

  const handleClick = (e: React.MouseEvent) => {
    const input = $('input', e.currentTarget.parentElement as HTMLElement) as HTMLInputElement
    if (input !== null) {
      handleSearchClient(input)
    }
  }

  const handleSearchClient = (input: HTMLInputElement) => {
    const value = input.value
    
    if (!isEmpty(value)) {
      onSearchClient(value)
    }
  }

  return (
    <div className='gck-search-client'>
      <div className='gck-search-client-input'>
        <input 
          onKeyUp={handlKeyUp} onBlur={handleBlur} onFocus={handleFocus} 
          ref={input} placeholder='Rechercher client par folio' type="text" 
        />
        {fetchStatus === 'fetching' 
          ? <span>...</span>
          : <Icon className="search-link-icon" name="result-search" size={60}
              onClick={handleClick} 
            />
        }
      </div>
    </div>
  )
}

const getParentElement = function(child: HTMLElement): HTMLElement
{
  if (child.parentElement === null) {
    throw new Error(`L'enfant ${child} n'a pas de parent`)
  }
  return child.parentElement
}