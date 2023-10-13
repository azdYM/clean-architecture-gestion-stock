import React, { useContext } from "react";
import { displaySearchbox } from "../functions/popup";
import { SearchContext } from "../functions/context";

 
export const SearchInput = () =>
{    
    const { updateSearch } = useContext(SearchContext)

    const handleChange = (e: React.FormEvent<HTMLInputElement>) => {
        const input = e.currentTarget as HTMLInputElement
        const searchBox = getSearchBox(input)
        const positionX = searchBox.getBoundingClientRect().left
        const positionY = searchBox.getBoundingClientRect().bottom
        const width = searchBox.offsetWidth
        
        //Evite de fermer le box contenant les resultats de recherche lorsqu'on clique
        //sur le input
        input.addEventListener('click', e => e.stopPropagation())
        
        displaySearchbox({x: positionX, y: positionY}, width)
        if (updateSearch !== null) updateSearch(input.value)
    }

    const handleFocus = (e: React.FocusEvent<HTMLInputElement>) => {
        const searchBox = getSearchBox(e.currentTarget)
        searchBox?.classList.add('focus')
    }

    const handleBlur = (e: React.FocusEvent<HTMLInputElement>) => {
        const searchBox = getSearchBox(e.currentTarget)
        searchBox?.classList.remove('focus')
    }

    function getSearchBox(input: HTMLInputElement) 
    {
        // Je sais que c'est de la merde mais bon ...

        if (input.parentElement === null) {
            throw new Error(`${input.parentElement} n'a pas de parent`)
        }

        if (input.parentElement.parentElement === null) {
            throw new Error(`${input.parentElement} n'a pas de parent`)
        }

        if (input.parentElement.parentElement.parentElement === null) {
            throw new Error(`${input.parentElement} n'a pas de parent`)
        }

        if (input.parentElement.parentElement.parentElement.parentElement === null) {
            throw new Error(`${input.parentElement} n'a pas de parent`)
        }

        return input.parentElement.parentElement.parentElement.parentElement
    }

    return (
        <div className="search-input">
            <input 
                onChange={handleChange} onBlur={handleBlur} onFocus={handleFocus}
                name="search_query" type="text" placeholder="Rechercher" 
                aria-label="Rechercher" autoCapitalize="none" autoComplete="off" autoCorrect="off"
            />
        </div>
    )
}