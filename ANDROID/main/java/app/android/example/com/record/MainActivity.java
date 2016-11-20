package app.android.example.com.record;

import android.net.Uri;
import android.os.AsyncTask;
import android.speech.tts.TextToSpeech;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.Locale;

import android.app.Activity;
import android.content.ActivityNotFoundException;
import android.content.Intent;
//import android.os.Bundle;
import android.speech.RecognizerIntent;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class MainActivity extends Activity {

    private TextView txtSpeechInput;
    private TextView txtSpeechOutput;
    private ImageButton btnSpeak;
    private final int REQ_CODE_SPEECH_INPUT = 100;
    public TextToSpeech t1;
    private ImageButton b1;

//    public void onInit(int initStatus) {
//
//        t1=new TextToSpeech(getApplicationContext(), new TextToSpeech.OnInitListener() {
//            @Override
//            public void onInit(int status) {
//                if(status != TextToSpeech.ERROR) {
//                    t1.setLanguage(Locale.UK);
//                }
//            }
//        });
//
//        // check for successful instantiation
//        if (initStatus == TextToSpeech.SUCCESS) {
//            if (t1.isLanguageAvailable(Locale.US) == TextToSpeech.LANG_AVAILABLE)
//                t1.setLanguage(Locale.US);
//        } else if (initStatus == TextToSpeech.ERROR) {
//            Toast.makeText(this, "Sorry! Text To Speech failed...",
//                    Toast.LENGTH_LONG).show();
//        }
//    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        txtSpeechInput = (TextView) findViewById(R.id.txtSpeechInput);
        txtSpeechOutput = (TextView) findViewById(R.id.txtSpeechOutput);
        btnSpeak = (ImageButton) findViewById(R.id.btnSpeak);
        b1 = (ImageButton) findViewById(R.id.btnTalk);

        t1=new TextToSpeech(getApplicationContext(), new TextToSpeech.OnInitListener() {
            @Override
            public void onInit(int status) {
                if(status != TextToSpeech.ERROR) {
                    t1.setLanguage(Locale.FRANCE);
                }
            }
        });

        b1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String toSpeak = txtSpeechInput.getText().toString();
                Toast.makeText(getApplicationContext(), toSpeak,Toast.LENGTH_SHORT).show();
                //String trans = "Say hello to my little friend";
                new GetTranslationTask().execute(toSpeak);
                //t1.speak(toSpeak, TextToSpeech.QUEUE_FLUSH, null);
            }
        });

        // hide the action bar
        //getActionBar().hide();

        btnSpeak.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                promptSpeechInput();
            }
        });
        //txtSpeechInput.setText("Testing");
        //speakWords("Testing");

    }

    public void speakWords(String speech) {

        // speak straight away
        t1.speak(speech, TextToSpeech.QUEUE_FLUSH, null);
    }

    /**
     * Showing google speech input dialog
     * */
    private void promptSpeechInput() {
        Intent intent = new Intent(RecognizerIntent.ACTION_RECOGNIZE_SPEECH);
        intent.putExtra(RecognizerIntent.EXTRA_LANGUAGE_MODEL,
                RecognizerIntent.LANGUAGE_MODEL_FREE_FORM);
        intent.putExtra(RecognizerIntent.EXTRA_LANGUAGE, Locale.getDefault());
        intent.putExtra(RecognizerIntent.EXTRA_PROMPT,
                getString(R.string.speech_prompt));
        try {
            startActivityForResult(intent, REQ_CODE_SPEECH_INPUT);
        } catch (ActivityNotFoundException a) {
            Toast.makeText(getApplicationContext(),
                    getString(R.string.speech_not_supported),
                    Toast.LENGTH_SHORT).show();
        }
    }

//    private String translateText(String trans) {
//        String res = "testing";
//        if (trans.isEmpty()) {
//            return "Nåt gick snett";
//        }
//
//        HttpURLConnection urlConnection = null;
//        BufferedReader reader = null;
//
//        // Will contain the raw JSON response as a string.
//        String forecastJsonStr = null;
//        String format = "plain";
//        String lang = "en-fr";
//        String apikey = "trnsl.1.1.20161120T095352Z.d04c8868138af811.50da8dc61d350802f9cf417f1718d51451f6023c";
//
//        try {
//            final String BASE_URL = "https://translate.yandex.net/api/v1.5/tr.json/translate?";
//            final String TEXT_PARAM = "text";
//            final String LANG_PARAM = "lang";
//            final String FORMAT_PARAM = "format";
//            final String KEY_PARAM = "key";
//
//            Uri builtUri = Uri.parse(BASE_URL).buildUpon()
//                    .appendQueryParameter(KEY_PARAM, apikey)
//                    .appendQueryParameter(TEXT_PARAM, trans)
//                    .appendQueryParameter(LANG_PARAM, lang)
//                    .appendQueryParameter(FORMAT_PARAM, format)
//                    .build();
//
//            URL url = new URL(builtUri.toString());
//            Log.v("URL:", "URL: " + url);
//            urlConnection = (HttpURLConnection) url.openConnection();
//            urlConnection.setRequestMethod("GET");
//            urlConnection.connect();
//
//            InputStream inputStream = urlConnection.getInputStream();
//            StringBuffer buffer = new StringBuffer();
//            if (inputStream == null) {
//                return null;
//            }
//            reader = new BufferedReader(new InputStreamReader(inputStream));
//
//            String line;
//            while ((line = reader.readLine()) != null) {
//                // Since it's JSON, adding a newline isn't necessary (it won't affect parsing)
//                // But it does make debugging a *lot* easier if you print out the completed
//                // buffer for debugging.
//                buffer.append(line + "\n");
//            }
//
//            if (buffer.length() == 0) {
//                // Stream was empty.  No point in parsing.
//                return null;
//            }
//
//            forecastJsonStr = buffer.toString();
//            Log.v("FECTHED", "TXTJSON:" + forecastJsonStr);
//            // VIEWTEXT
//        } catch (IOException e) {
//            Log.e("ERROR", "Error ", e);
//            return null;
//        //} catch (JSONException e) {
//        //    Log.e("ERROR", e.getMessage(), e);
//        //    e.printStackTrace();
//        } finally {
//            if (urlConnection != null) {
//                urlConnection.disconnect();
//            }
//            if (reader != null) {
//                try {
//                    reader.close();
//                } catch (final IOException e){
//                    Log.e("ERROR", "Error closing stream", e);
//                }
//            }
//        }
//
//
//        return res;
//    }

    /**
     * Receiving speech input
     * */
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        switch (requestCode) {
            case REQ_CODE_SPEECH_INPUT: {
                if (resultCode == RESULT_OK && null != data) {

                    ArrayList<String> result = data
                            .getStringArrayListExtra(RecognizerIntent.EXTRA_RESULTS);
                    txtSpeechInput.setText(result.get(0));
                    txtSpeechOutput.setText("");

                }
                break;
            }

        }
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        //getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }



    class GetTranslationTask extends AsyncTask<String, Void, String> {

        private String getTransText(String json) throws JSONException {
            final String T_TEXT = "text";
            try {
                JSONObject forecastJson = new JSONObject(json);
                JSONArray textObject = forecastJson.getJSONArray(T_TEXT);
                String translation = textObject.getString(0);
                if (translation != null) {
                    Log.v("Transplation: ", translation);
                    return translation;
                } else {
                    return "snett";
                }
            } catch (JSONException e) {
                Log.e("JSONERROR", e.getMessage(), e);
                e.printStackTrace();
                return "Error JSON";
            }
        }

        @Override
        protected String doInBackground(String... params) {
            String res = "..";
            //String res = "testing";
            if (params.length == 0) {
                return "";
            }

            String trans = params[0];
            HttpURLConnection urlConnection = null;
            BufferedReader reader = null;

            // Will contain the raw JSON response as a string.
            String forecastJsonStr;
            String format = "plain";
            String lang = "sv-fr";
            String apikey = "trnsl.1.1.20161120T095352Z.d04c8868138af811.50da8dc61d350802f9cf417f1718d51451f6023c";

            try {
                final String BASE_URL = "https://translate.yandex.net/api/v1.5/tr.json/translate?";
                final String TEXT_PARAM = "text";
                final String LANG_PARAM = "lang";
                final String FORMAT_PARAM = "format";
                final String KEY_PARAM = "key";

                Uri builtUri = Uri.parse(BASE_URL).buildUpon()
                        .appendQueryParameter(KEY_PARAM, apikey)
                        .appendQueryParameter(TEXT_PARAM, trans)
                        .appendQueryParameter(LANG_PARAM, lang)
                        .appendQueryParameter(FORMAT_PARAM, format)
                        .build();

                URL url = new URL(builtUri.toString());
                Log.v("URL:", "URL: " + url);
                urlConnection = (HttpURLConnection) url.openConnection();
                urlConnection.setRequestMethod("GET");
                urlConnection.connect();

                InputStream inputStream = urlConnection.getInputStream();
                StringBuffer buffer = new StringBuffer();
                if (inputStream == null) {
                    return null;
                }
                reader = new BufferedReader(new InputStreamReader(inputStream));

                String line;
                while ((line = reader.readLine()) != null) {
                    // Since it's JSON, adding a newline isn't necessary (it won't affect parsing)
                    // But it does make debugging a *lot* easier if you print out the completed
                    // buffer for debugging.
                    buffer.append(line + "\n");
                }

                if (buffer.length() == 0) {
                    // Stream was empty.  No point in parsing.
                    return null;
                }

                forecastJsonStr = buffer.toString();
                Log.v("FECTHED", "TXTJSON:" + forecastJsonStr);
                return getTransText(forecastJsonStr);
                // VIEWTEXT
            } catch (IOException e) {
                Log.e("ERROR", "Error ", e);
                return null;
                } catch (JSONException e) {
                    Log.e("ERROR", e.getMessage(), e);
                    e.printStackTrace();
            } finally {
                if (urlConnection != null) {
                    urlConnection.disconnect();
                }
                if (reader != null) {
                    try {
                        reader.close();
                    } catch (final IOException e) {
                        Log.e("ERROR", "Error closing stream", e);
                    }
                }
            }
            return res;
        }

        protected void onPostExecute(String res) {
            //dosomething with res
            txtSpeechOutput.setText(res);
            t1.speak(res, TextToSpeech.QUEUE_FLUSH, null);
        }
    }
}
