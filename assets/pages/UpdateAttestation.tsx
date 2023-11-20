import { useQuery } from "@tanstack/react-query"
import { useRef } from "react"
import { getAttestation } from "../api/attestation"
import { Page } from "../components/Page"
import { FormGageEvaluation } from "./EvaluateGage"
import { useParams } from "react-router-dom"
import { CardError } from "../components/CardError"
import { Loading } from "../components/Loading"

export const UpdateAttestation = () => {
  const pageRef = useRef<HTMLDivElement>(null)
  const {id: idAttestation} = useParams()

  const { data, status, error } = useQuery({
    queryKey: ['attestation', idAttestation],
    queryFn: () => getAttestation(idAttestation),
    enabled: !!idAttestation,
  })

  return (
    <Page pageTitle='Update attestation' sidebarShowed={false} ref={pageRef}>
      <h1 className='page-title'>Mise à jour d'une attestation</h1>
      {status === 'loading' && <Loading />}
      {error 
      ? <CardError error={error as Error} />
      : (
        <FormGageEvaluation error={error} data={data} pageRef={pageRef} />
      )
    }
    </Page>
  )
}