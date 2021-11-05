<?php


namespace Lack\OidServer\Base\Interface;


interface ClaimManagerInterface
{

    /**
     * Validate scopes are allowed for client and user
     *
     * Throws InvalidArguementException if
     *
     * @param ClientInterface $client
     * @param UserInterface|null $user
     * @param array $scopes
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function validateScopes(ClientInterface $client, UserInterface $user = null, array $scopes = []) : void;

    /**
     * Return an array of claims for the id token according to the scopes provided in parameter 3
     *
     * <example>
     *
     * </example>
     *
     * @param ClientInterface $client
     * @param UserInterface|null $user
     * @param array $scopes
     * @return array [
     *  'sub'       => (string) Unique UserId - permanent identifier (openid)
     *  'iss'       => (string) Hostname of the key4s service (openid)
     *  'aud'       => (string) For id-token: The client_id (openid)
     *  'exp'       => (int) Expires ät Unix Timestamp (openid)
     *  'iat'       => (int) Issued at Unix timestamp (openid)
     *  'name'      => (string) (profile)
     *  'given_name'=> (string) (profile)
     *  'family_name'=> (string) (profile)
     *  'nickname'    => (string)
     *  'picture'   => (string) (profile)
     *  'updated_at'=> (int) Unix timestamp (profile)
     *  'email'     => (string) Email (email)
     *  'email_verified' => (bool) Was the email verified (email)
     * ]
     */
    public function getIdClaims(ClientInterface $client, UserInterface $user = null, array $scopes = []) : array;

    /**
     * @param ClientInterface $client
     * @param UserInterface|null $user
     * @param array $scopes
     * @return array [
     *  'sub'       => (string) Unique UserId - permanent identifier (openid)
     *  'iss'       => (string) Hostname of the key4s service (openid)
     *  'aud'       => (array) Array of APIs this token is made for
     *  'exp'       => (int) Expires ät Unix Timestamp (openid)
     *  'iat'       => (int) Issued at Unix timestamp (openid)
     *  'azp'       => (string) Authorize Party - the client_id
     *  'scope'     => (string) Space separated list of scopes
     * ]
     */
    public function getAccessClaims(ClientInterface $client, UserInterface $user = null, array $scopes = []) : array;

}
