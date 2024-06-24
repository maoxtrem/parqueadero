import { fetch_async_formData, on, message_server } from "./util"


on('submit', '#form_register', async (e) => {
    e.preventDefault();
    const form = new FormData(e.target);
    const response = await fetch_async_formData(rutes.register, form)
    message_server(response.message)
})