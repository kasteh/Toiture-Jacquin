<div>
    Bonjour {{env('APP_OWNER_NAME')}},
    <br>
    <br>
    Quelqu'un vous a contacté, voici ses informations:
    <ul>
        <li><strong>Nom:</strong> {{!empty($data['name']) ? $data['name'] : 'Non indiqué !'}}</li>
        <li><strong>Code Postal:</strong> {{!empty($data['code']) ? $data['code'] : 'Non indiqué !'}}</li>
        <li><strong>Adresse Email:</strong> {{!empty($data['email']) ? $data['email'] : 'Non indiqué !'}}</li>
        <li><strong>Numéro de téléphone:</strong> {{!empty($data['phone']) ? $data['phone'] : 'Non indiqué !'}}</li>
        <li><strong>Message:</strong> {{!empty($data['message']) ? $data['message'] : 'Non indiqué !'}}</li>
    </ul>
    Bien à vous.
</div>