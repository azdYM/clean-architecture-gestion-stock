import { Corporate, Individual } from "../components/CardClient"

export type UserData = {
  id: number,
  fullname: string,
  email: string,
  username: "string",
  roles: Array<keyof typeof RoleUser>
  agency?: Agency
  workingService?: string
}

type Agency = {
  id: number,
  label: string,
}

export enum RoleUser {
  'ROLE_CREDIT_MANAGER',
  'ROLE_GAGE_MANAGER',
  'ROLE_AGENCY_MANAGER',
  'ROLE_GAGE_EVALUATOR',
  'ROLE_GAGE_SUPERVISOR',
  'ROLE_CREDIT_AGENT',
  'ROLE_CREDIT_SUPERVISOR',
}

export const getUserRoles = function(roles: Array<keyof typeof RoleUser>) {
  return roles.map(role => getUserRole(role))
}

export const getUserRole = function(role: keyof typeof RoleUser) {
  switch (role) {
    case 'ROLE_AGENCY_MANAGER':
        return {key: role, value: "Chef d'agence"}	
    case 'ROLE_CREDIT_AGENT':
        return {key: role, value: "Agent de crédit"}
    case 'ROLE_CREDIT_MANAGER':
        return {key: role, value: "Chef de crédit"}
    case 'ROLE_CREDIT_SUPERVISOR':
        return {key: role, value: "Superviseur de crédit"}
    case 'ROLE_GAGE_EVALUATOR':
        return {key: role, value: "Evaluateur de gage"}
    case 'ROLE_GAGE_MANAGER':
        return {key: role, value: "Chef de gage"}
    case 'ROLE_GAGE_SUPERVISOR':
        return {key: role, value: "Superviseur de gage"}

    default:
        throw new Error(`Le role ${role} n'est pris en charge par notre système`);
}
}

export const getCurrentUser = async (): Promise<UserData> => {
  try {
    const res = await fetch(`http://localhost:8000/api/me/employee`);
    
    if (!res.ok) {
      throw new Error(`Request failed with status ${res.status}`);
    }

    return res.json();
  } catch (error) {
    throw new Error(`An error occurred: ${error}`);
  }
}

export const isIndividualClient = function(object: any): object is Individual
{
  return (
    typeof object === 'object' 
    && object !== null 
    && 'nin' in object
    && 'birthDay' in object
  )
}

export const isCorporateClient = function(object: any): object is Corporate
{
  return (
    typeof object === 'object' 
    && object !== null 
    && 'legalForm' in object
    && 'comericialRegistry' in object
  )
}
