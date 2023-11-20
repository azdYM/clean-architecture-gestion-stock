import { NavLink } from 'react-router-dom'
import { Icon } from '../components/Icon'
import { substring } from '../functions/string'
import { LinksType, UserRolesType, getUserActions, routes } from '../functions/links'

export const GuideContent = () => {
	return (
		<div className='gck-guide-renderer' id="guide-content">
			<RenderSections />
		</div>
	)    
}

const RenderSections = function()
{
	return (
		<div className="sections">
			<RenderBaseSection />
		</div>
	)
}

const RenderBaseSection = function() 
{
	const userRoles = [
		{key: 'ROLE_GAGE_EVALUATOR', value: 'Evaluateur de gage'},
		{key: 'ROLE_CREDIT_AGENT', value: 'Agent de crédit'}
	]

	return (
		<div className='gck-guide-section-renderer'>
			<RenderBaseLinks />
			<RenderCustomLinks roles={userRoles} />
		</div>
	)
}

const RenderBaseLinks = function()
{
	const links = [
		{label: 'Acceuil', path: routes.home, icon: 'home'},
		{label: 'Historique', path: routes.history, icon: 'history'},
		{label: 'Attestations de gage', path: routes.attestations, icon: 'list-attestation'},
		{label: 'Contrats de crédit', path: routes.credits, icon: 'list-credit'}
	]

	return (
		<>
			{links.map((link, index) => (
				<div className='mck-guide-entry-renderer' key={index}>
					<LinkWrapper label={link.label} path={link.path} icon={link.icon} />
				</div>
			))}
		</>
	)
}   

const RenderCustomLinks = function({roles}: {roles: UserRolesType[]})
{
	return (
		<>
			{roles.map((role, index) => (
				<div className='mck-guide-collaps-entry-rendering' key={index}>
					<RenderLinksForRole role={role} />
				</div>
			))}
		</>
	)
}

const RenderLinksForRole = function({role}: {role: UserRolesType})
{
	const links = getUserActions(role.key)

	return (
		<>
			{links.map((action, index) => <RenderLink key={index} {...action} />)}
		</>
	)
}

const RenderLink = function({label, path, icon}: LinksType)
{
	return (
		<div className='mck-guide-entry-renderer'>
			<LinkWrapper label={substring(label, 20)} path={path} icon={icon} />
		</div>
	)
}

type PropsLink = {label: string, icon: string, path: string, className?: string}

const LinkWrapper = function({label, icon, path, className=''}: PropsLink)
{
	return (
		<NavLink 
			className={({isActive}) => 
				isActive ? 'link-menu clicked' : `link-menu ${className}`
			}
			to={path}
		>
			<Icon className="link-icon" size={80} name={icon} />
			<span className="link-label">{label}</span>
		</NavLink>
	)
}