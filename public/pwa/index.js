let installPrompt = null;
const installButton = document.querySelector("#installPWA");
const installButtonSM = document.querySelector("#installPWAsm");
window.addEventListener("beforeinstallprompt", (event) => {
    event.preventDefault();
    installPrompt = event;
});
installButton?.addEventListener("click", async () => {
    if (!installPrompt) {
        return;
    }
    const result = await installPrompt.prompt();
    installPrompt = null;
});

installButtonSM?.addEventListener("click", async () => {
    
    if (!installPrompt) {
        return;
    }
    const result = await installPrompt.prompt();
    installPrompt = null;
});