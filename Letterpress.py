import copy

ENEMY = 2
NEUTRAL = 1
MINE = 0
DISPLAY = 25
OUTPUT = 1000

dict = open('letterpress.txt', 'r')
words = dict.readlines()
enemy = raw_input().lower()
neutral = raw_input().lower()
mine = raw_input().lower()
letters = enemy + neutral + mine
freq = [0] * 128
efreq = [0] * 128
nfreq = [0] * 128
mfreq = [0] * 128

print len(enemy), '+', len(neutral), '+', len(mine), '=', len(letters)
assert len(letters) == 25

for letter in letters:
    freq[ord(letter)] += 1

for letter in enemy:
    efreq[ord(letter)] += 1

for letter in neutral:
    nfreq[ord(letter)] += 1

for letter in mine:
    mfreq[ord(letter)] += 1

efreq_copy = copy.deepcopy(efreq)
nfreq_copy = copy.deepcopy(nfreq)
mfreq_copy = copy.deepcopy(mfreq)
good_words = []

def get_score(word):
    global efreq, nfreq, mfreq
    score = 0

    for letter in word:
        c = ord(letter)

        if efreq[c] > 0:
            score += ENEMY
            efreq[c] -= 1
        elif nfreq[c] > 0:
            score += NEUTRAL
            nfreq[c] -= 1
        elif mfreq[c] > 0:
            score += MINE
            mfreq[c] -= 1

    efreq = copy.deepcopy(efreq_copy)
    nfreq = copy.deepcopy(nfreq_copy)
    mfreq = copy.deepcopy(mfreq_copy)
    return score

for word in filter(lambda w: len(w) >= 1, words):
    word = word[:-1]
    good = True

    for letter in word:
        c = ord(letter)
        freq[c] -= 1

        if freq[c] < 0:
            good = False

    if good:
        good_words.append((get_score(word), word))

    for letter in word:
        c = ord(letter)
        freq[c] += 1

good_words.sort(key = lambda x: (x[0], len(x[1])), reverse=True)
print len(good_words)

for pair in good_words[:DISPLAY]:
    print pair[1], pair[0]

output = open('words.txt', 'w')

for pair in good_words[:OUTPUT]:
    output.write(pair[1] + ' ' + str(pair[0]) + '\n')