# coding: utf-8

import numpy as np
import matplotlib.pyplot as plt
height = [53, 47]
bars = ('Oui', 'Non')
y_pos = np.arange(len(bars))
plt.barh(bars, height, color=(0.2, 0.4, 0.6, 0.6))
 
# Custom Axis title
plt.xlabel(u'Réponses (%)', fontweight='bold', color = 'grey', fontsize='17', horizontalalignment='center')
plt.yticks(y_pos, bars, color='grey', fontweight='bold', fontsize='17', horizontalalignment='right')
 

plt.show()
