# Qiwi_webhook
Qiwi library for init webhook and get data from it
https://developer.qiwi.com/ru/qiwi-wallet-personal

# Info 
Init lib by API-key.
```$qiwi = new Qiwi('API KEY');```
 
You can get this API key here https://qiwi.com/api

# Methods
```$qiwi->set_hook_url($url);```

This method is used to register the webhook handler. Previously there is a removal of the last handler. The method returns the id of the new handler.

```$qiwi->get_hook_key($hook_id);```

This method is used to retrieve the hook's private key.

```$qiwi->send_test_hook();```

This method is used to send a test notification to the hook.

```$qiwi->getLastHookUrl();```

This method is used to get last webhook url
