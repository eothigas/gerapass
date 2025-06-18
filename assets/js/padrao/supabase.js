const supabaseUrl = 'https://zmgpptulptgpxbtqfnwe.supabase.co';
const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InptZ3BwdHVscHRncHhidHFmbndlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTAyMDgwNzcsImV4cCI6MjA2NTc4NDA3N30.JCCiaEMrxx7W60LnGWVY7pXEMNw-HVgT9Z0JzXRzhKU';

const supabaseClient = window.supabase.createClient(supabaseUrl, supabaseKey);

async function verificarConexaoSupabase() {
    try {
        const { error } = await supabaseClient.from('usuarios').select('*').limit(1);
        if (error) {
        console.error('❌ Erro ao conectar ao Supabase:', error.message);
        alert('Falha na conexão com o Supabase. Verifique a chave ou a URL.');
        } else {
        console.log('✅ Conectado ao Supabase com sucesso!');
        }
    } catch (e) {
        console.error('❌ Erro inesperado:', e);
        alert('Erro inesperado ao conectar ao Supabase.');
    }
}


verificarConexaoSupabase();