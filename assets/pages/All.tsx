import { AttestationsRenderer, } from '../components/AttestationsRenderer'
import { useQuery } from '@tanstack/react-query'
import { getAllAttestation, groupeAttestationByDate } from '../api/attestation'
import { ContractsRenderer } from '../components/ContractsRenderer'
import { getAllCredit } from '../api/credit'
import { useMemo } from 'react'

export const AttestationsAll = function()
{
  const { data, status, error } = useQuery({
    queryKey: ['all_attestation'],
    queryFn: () => getAllAttestation(),
  }) 
  const attestations = useMemo(() => groupeAttestationByDate(data), [data]);
  
  return <AttestationsRenderer data={attestations} status={status} error={error} />
}

export const ContractsAll = () =>
{
  const { data, status, error } = useQuery({
    queryKey: ['all_credit'],
    queryFn: () => getAllCredit(),
  }) 

  return (
    <ContractsRenderer data={data} status={status} error={error} />
  )
}