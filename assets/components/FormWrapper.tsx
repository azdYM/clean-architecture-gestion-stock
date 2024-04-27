import React from "react"
import { formDataToStructuredObject } from "../functions/object"

type FormWrapperProps = {
  className?: string,
  onSubmit: (data: {[key: string]: any}) => void,
  method?: ('POST'|'GET')
}

export const FormWrapper = ({children, method = 'POST', onSubmit, className}: React.PropsWithChildren<FormWrapperProps>) => {
  
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    
    const formData = new FormData(e.currentTarget as HTMLFormElement)
    const formDataObject = formDataToStructuredObject(formData)

    onSubmit(formDataObject)
  }

  return (
    <div className='gck-form-wrapper'>
      <div className={`gck-form ${className}`}>
      <form onSubmit={handleSubmit} method={method}>
        {children}
      </form>
      </div>
    </div>
  )
}

