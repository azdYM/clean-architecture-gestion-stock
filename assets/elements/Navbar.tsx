import { useState } from "react"
import { GuideSidebarButton } from "../components/GuideSidebarButton"
import { Icon } from "../components/Icon"
import { Logo } from "../components/Logo"
import { SearchBox } from "../components/SearchBox"
import { SearchInput } from "../components/SerchInput"
import { TopBarAvatar } from "../components/TopBarAvatar"
import { TopBarNotificationButton } from "../components/TopBarNotificationButton"
import { SearchContext } from "../functions/context"

export const MastheadContainer = () =>
{
	return (
		<div id="azd-masthead">
			<nav className="gck-nav-masthead">
				<NavbarStartElement />
				<NavbarCenterElement />
				<NavbarEndElement />
			</nav>
		</div>
	)
}

const NavbarStartElement = function()
{
	return (
		<div id="start">
			<GuideSidebarButton />
			<Logo name="logo_meck_moroni" size={100} className="gck-logo" />
		</div>
	)
}

const NavbarCenterElement = function()
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

const SearchProvider = function({children}: React.PropsWithChildren)
{
	const [search, setSearch] = useState('')

	return (
		<SearchContext.Provider value={{search, updateSearch: (value) => setSearch(value)}}>
			{ children }
		</SearchContext.Provider>
	)
}

const TopSearchBar = function({children}: React.PropsWithChildren)
{
    return (
        <div id="search" className="gcrdt-topbar-searchbox">
            <form id="search-form"  action="">
                <div id="searchbox" className="searchbox-content">
                    { children }
                </div>
            </form>
            <button id="search-icon"></button>
        </div>
    )
}

const SearchClearButton = function()
{
    return (
        <div id="search-clear-button"></div>
    )
}

const NavbarEndElement = function()
{
	return (
		<div id="buttons">
			<TopBarNotificationButton />
			<TopBarAvatar />
		</div>
	)
}

