import { useContext } from "react"
import { useDisplayPopUp } from "/functions/hooks"
import { SearchContext } from "/functions/context"
import { Icon } from "./Icon"


export const SearchBox = () =>
{
    const elementName = 'gcrdt-popup-searchbox'
    const displayed = useDisplayPopUp(elementName)
    
    return (
        <gcrdt-popup-searchbox class="gcrdt-popup-container" style={{display: 'none', outline: 'none', position: 'fixed'}}>
            <SearchBoxWrapper displayed={displayed} />
        </gcrdt-popup-searchbox>
    )
}

function SearchBoxWrapper({displayed})
{
    if (!displayed) return 

    const { search } = useContext(SearchContext)
    const searchResults = [
        {path: '#', fullname: "Abdoul-wahid Hassani", folio: "66166"},
        {path: '#', fullname: "Abdoul-karim Ibrahim", folio: "23453"},
        {path: '#', fullname: "Radjabou Saandi Islam", folio: "45643"},
        {path: '#', fullname: "Nasma Abdoul-fatah", folio: "32431"},
        {path: '#', fullname: "Imamou Mina", folio: "63421"},
        {path: '#', fullname: "Said Hassani", folio: "67900"},
        {path: '#', fullname: "Mohamed Adam", folio: "10234"},
    ]

    return (
        <div className="popup-wrapper content-search-result" >
            <div id="spinner"></div>
            <SearchResults results={searchResults}/>
        </div>
    )
}

function SearchResults({results})
{
    return (
        results.map((result, index) => <ItemSearchResult key={index} item={result} />)
    )
}

function ItemSearchResult({item}) 
{
    return (
        <a className="link-menu" href={item.path}>
            <Icon className="link-icon" name="result-search" size={70} />
            <div className="client-about">
                <span>{item.fullname}</span>
                <span className="folio">{item.folio}</span>
            </div>
        </a>
    )
}