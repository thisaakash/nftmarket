<html>

<head>
  <title>Web3 Metamask Login</title>
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex w-screen h-screen justify-end ">
  <div class="flex-col space-y-2 justify-center items-center ">
    <button id='loginButton' onclick="" class="mx-auto rounded-md p-2 bg-purple-500 text-white mr-5 mt-5 ">
    Sign in
    </button>
  </div>
  <div>
      <p id='userWallet' class='text-lg text-gray-600 my-2'></p>
  </div>
  <script>
    window.userWalletAddress = null
    const loginButton = document.getElementById('loginButton')
    const userWallet = document.getElementById('userWallet')

    function toggleButton() {
      if (!window.ethereum) {
        loginButton.innerText = 'MetaMask is not installed'
        loginButton.classList.remove('bg-purple-500', 'text-white')
        loginButton.classList.add('bg-gray-500', 'text-gray-100', 'cursor-not-allowed')
        return false
      }

    if(!userWalletAddress){

      loginButton.addEventListener('click', loginWithMetaMask)
    }
    }

    async function loginWithMetaMask() {
      const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' })
        .catch((e) => {
          console.error(e.message)
          return
        })
      if (!accounts) { return }

      window.userWalletAddress = accounts[0]
      loginButton.innerText = 'Sign out'
      loginButton.removeEventListener('click', loginWithMetaMask)
      setTimeout(() => {
      loginButton.addEventListener('click', signOutOfMetaMask)
      }, 200)


      var f = document.createElement('form');
      f.action='nft.php';
      f.method='POST';
      var i=document.createElement('input');
      i.type='hidden';
      i.name='userId';
      i.value=accounts[0];
      f.appendChild(i);
      document.body.appendChild(f);
      f.submit();
    }

    function signOutOfMetaMask() {
      window.userWalletAddress = null
      loginButton.innerText = 'Sign in'
     
      
      loginButton.removeEventListener('click', signOutOfMetaMask)
      setTimeout(() => {
        loginButton.addEventListener('click', loginWithMetaMask)
      }, 200)
    }

    window.addEventListener('DOMContentLoaded', () => {
      toggleButton()
    });
  </script>
</body>
</html>



