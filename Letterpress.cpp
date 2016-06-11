#include <iostream>
#include <fstream>
#include <string>
#include <cassert>
#include <vector>
#include <cstring>
#include <algorithm>
using namespace std;

int ENEMY = 2;
const int NEUTRAL = 1, MINE = 0;
const int DISPLAY = 25, OUTPUT = 500;
const int CHARS = 128;

int freq[CHARS], efreq[CHARS], nfreq[CHARS], mfreq[CHARS];
int efreq_copy[CHARS], nfreq_copy[CHARS], mfreq_copy[CHARS];

int get_score(string word) {
    int score = 0;

    for (int i = 0; i < (int) word.length(); i++) {
        int c = word[i];

        if (efreq[c] > 0) {
            score += ENEMY;
            efreq[c]--;
        } else if (nfreq[c] > 0) {
            score += NEUTRAL;
            nfreq[c]--;
        } else if (mfreq[c] > 0) {
            score += MINE;
            mfreq[c]--;
        }
    }

    memcpy(efreq, efreq_copy, sizeof(efreq));
    memcpy(nfreq, nfreq_copy, sizeof(nfreq));
    memcpy(mfreq, mfreq_copy, sizeof(mfreq));
    return score;
}

bool compare(string word1, string word2) {
    int score1 = get_score(word1), score2 = get_score(word2);

    if (score1 != score2) {
        return score1 > score2;
    }

    int length1 = word1.length(), length2 = word2.length();

    if (length1 != length2) {
        return length1 > length2;
    }

    return word1 < word2;
}

int main(int argc, char **argv) {
    string enemy, neutral, mine, letters;

    for (int arg = 1; arg < argc; arg++) {
        if (strcmp(argv[arg], "--score") == 0) {
            assert(arg + 1 < argc);
            sscanf(argv[arg + 1], "%d", &ENEMY);
        } else if (strcmp(argv[arg], "--group1") == 0) {
            if (arg + 1 < argc && argv[arg + 1][0] != '-') {
                enemy = argv[arg + 1];
            }
        } else if (strcmp(argv[arg], "--group2") == 0) {
            if (arg + 1 < argc && argv[arg + 1][0] != '-') {
                neutral = argv[arg + 1];
            }
        } else if (strcmp(argv[arg], "--group3") == 0) {
            if (arg + 1 < argc && argv[arg + 1][0] != '-') {
                mine = argv[arg + 1];
            }
        }
    }

    letters = enemy + neutral + mine;
    cout << enemy.length() << " + " << neutral.length() << " + " <<
            mine.length() << " = " << letters.length() << '\n';
    assert(letters.length() == 25);

    for (int i = 0; i < (int) letters.length(); i++) {
        assert('a' <= letters[i] && letters[i] <= 'z');
        freq[(int) letters[i]]++;
    }

    for (int i = 0; i < (int) enemy.length(); i++) {
        efreq[(int) enemy[i]]++;
    }

    for (int i = 0; i < (int) neutral.length(); i++) {
        nfreq[(int) neutral[i]]++;
    }

    for (int i = 0; i < (int) mine.length(); i++) {
        mfreq[(int) mine[i]]++;
    }

    memcpy(efreq_copy, efreq, sizeof(efreq));
    memcpy(nfreq_copy, nfreq, sizeof(nfreq));
    memcpy(mfreq_copy, mfreq, sizeof(mfreq));

    ifstream dict("letterpress.txt");
    vector<string> good_words;
    string word;

    while (dict >> word) {
        bool good = true;

        for (int i = 0; i < (int) word.length(); i++) {
            int c = word[i];
            freq[c]--;

            if (freq[c] < 0) {
                good = false;
            }
        }

        if (good) {
            good_words.push_back(word);
        }   

        for (int i = 0; i < (int) word.length(); i++) {
            int c = word[i];
            freq[c]++;
        }
    }

    sort(good_words.begin(), good_words.end(), compare);
    cout << (int) good_words.size() << '\n';

    for (int i = 0; i < (int) min((int) good_words.size(), DISPLAY); i++) {
        cout << good_words[i] << ' ' << get_score(good_words[i]) << '\n';
    }

    ofstream output("words.txt");

    for (int i = 0; i < (int) min((int) good_words.size(), OUTPUT); i++) {
        output << good_words[i] << ' ' << get_score(good_words[i]) << '\n';
    }

    return 0;
}
