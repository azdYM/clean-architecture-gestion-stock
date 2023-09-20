import React, { useContext } from "react";
import { displaySearchbox } from "/functions/popup";
import { SearchContext } from "/functions/context";

 
export const SearchInput = () =>
{    
    const { updateSearch } = useContext(SearchContext)

    const handleInput = (e) => {
        const parent = getSearchBox(e.currentTarget)
        const positionX = parent.getBoundingClientRect().left
        const positionY = parent.getBoundingClientRect().bottom
        const width = parent.offsetWidth
        
        //Evite de fermer le box contenant les resultats de recherche lorsqu'on clique
        //sur le input
        e.currentTarget.addEventListener('click', e => e.stopPropagation())

        displaySearchbox({x: positionX, y: positionY}, width)
        updateSearch(e.currentTarget.value)
    }

    const handleFocus = (e) => {
        const parent = getSearchBox(e.currentTarget)
        parent.classList.add('focus')
    }

    const handleBlur = (e) => {
        const parent = getSearchBox(e.currentTarget)
        parent.classList.remove('focus')
    }

    function getSearchBox(input) 
    {
        return input.parentElement.parentElement.parentElement.parentElement
    }

    return (
        <div className="search-input">
            <input 
                onInput={handleInput} onBlur={handleBlur} onFocus={handleFocus}
                name="search_query" type="text" placeholder="Rechercher" 
                aria-label="Rechercher" autoCapitalize="none" autoComplete="off" autoCorrect="off" tabIndex="0" 
            />
        </div>
    )
}