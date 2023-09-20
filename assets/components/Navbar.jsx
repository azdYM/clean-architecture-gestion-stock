import { createContext, useContext, useState } from "react"
import { GuideSidebarButton } from "./GuideSidebarButton"
import { Icon } from "./Icon"
import { Logo } from "./Logo"
import { SearchBox } from "./SearchBox"
import { SearchInput } from "./SerchInput"
import { TopBarAvatar } from "./TopBarAvatar"
import { TopBarNotificationButton } from "./TopBarNotificationButton"
import { SearchContext } from "/functions/context"

export const Navbar = () =>
{
	return (
		<nav className="container navbar">
			<NavbarStartElement />
			<NavbarCenterElement />
			<NavbarEndElement />
		</nav>
	)
}

function NavbarStartElement()
{
	return (
		<div id="start">
			<GuideSidebarButton />
			<Logo name="logo_meck_moroni" size={100} className="gck-logo" />
		</div>
	)
}

function NavbarCenterElement()
{
	return (
		<SearchProvider >
			<div id="center">
				<TopSearchBar>
					<Icon name={'search'} size={100} className="gcrdt-searchicon"/>
					<SearchInput />
					<SearchClearButton />
				</TopSearchBar>
			</div>
			<SearchBox />
		</SearchProvider>
	)
}

function SearchProvider({children})
{
	const [search, setSearch] = useState('')

	return (
		<SearchContext.Provider value={{search, updateSearch: (value) => setSearch(value)}}>
			{ children }
		</SearchContext.Provider>
	)
}

function TopSearchBar({ children })
{
    return (

        <gcrdt-searchbox id="search" class="gcrdt-topbar-searchbox">
            <form id="search-form"  action="">
                <div id="searchbox" className="searchbox-content">
                    { children }
                </div>
            </form>
            <button id="search-icon"></button>
        </gcrdt-searchbox>
    )
}


function SearchClearButton()
{
    return (
        <div id="search-clear-button"></div>
    )
}

function NavbarEndElement()
{
	return (
		<div id="buttons">
			<TopBarNotificationButton />
			<TopBarAvatar />
		</div>
	)
}

