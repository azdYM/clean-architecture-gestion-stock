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