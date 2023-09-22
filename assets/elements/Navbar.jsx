import { useState } from "react"
import { GuideSidebarButton } from "../components/GuideSidebarButton"
import { Icon } from "../components/Icon"
import { Logo } from "../components/Logo"
import { SearchBox } from "../components/SearchBox"
import { SearchInput } from "../components/SerchInput"
import { TopBarAvatar } from "../components/TopBarAvatar"
import { TopBarNotificationButton } from "../components/TopBarNotificationButton"
import { SearchContext } from "/functions/context"

export const MastheadContainer = () =>
{
	return (
		<div className="masthead-container">
			<gck-masthead>
				<nav className="container gck-masthead">
					<NavbarStartElement />
					<NavbarCenterElement />
					<NavbarEndElement />
				</nav>
			</gck-masthead>
		</div>
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

