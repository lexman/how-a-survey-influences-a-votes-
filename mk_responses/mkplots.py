# coding: utf-8

import numpy as np
import matplotlib.pyplot as plt


def mk_response(pct_yes):
    height = [pct_yes, 100 - pct_yes]
    bars = ('Oui', 'Non')
    y_pos = np.arange(len(bars))
    plt.figure(figsize=(5.6,2.5))
    plt.barh(bars, height, color=(0.2, 0.4, 0.6, 0.6))
    plt.xlabel(u'Réponses (%)', fontweight='bold', color = 'grey', fontsize='17', horizontalalignment='center')
    plt.yticks(y_pos, bars, color='grey', fontweight='bold', fontsize='17', horizontalalignment='right')
    label_yes = "{} %".format(pct_yes)
    plt.text(40, -0.1, label_yes, fontsize=17, fontweight='bold', color='#404040')
    label_no = "{} %".format(100 - pct_yes)
    plt.text(40, .9, label_no, fontsize=17, fontweight='bold', color='#404040')
     
    plt.savefig("../opendata/imgs/.private/responses/response_{}.png".format(pct_yes))
    plt.clf()
    #plt.show()

for i in range(1, 100):
    mk_response(i)

#mk_response(53)
